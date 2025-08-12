<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\SubjectOffer;
use App\Models\Subject;
use App\Models\GradeRecord;
use App\Models\SubjectRequest;
use App\Models\SemesterStart;

class CurrentSemesterController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // البحث عن الفصل الذي سجل فيه الطالب
        $registeredSemester = $this->getStudentRegisteredSemester($user);
        $currentSemesterNumber = SemesterStart::where('student_id', $user->id)->count();


        if (!$registeredSemester) {
            return redirect()->route('student.sem-details')
                ->with('error', 'يجب عليك التسجيل في فصل دراسي أولاً قبل عرض المواد');
        }

        // جلب المواد المسجلة للطالب في الفصل المسجل فيه
        $enrollments = Enrollment::where('student_id', $user->id)
            ->whereHas('subjectOffer', function($query) use ($registeredSemester) {
                $query->where('semester_id', $registeredSemester->id);
            })
            ->with(['subjectOffer.subject', 'subjectOffer.teacher'])
            ->get();

        // حساب إجمالي الوحدات الفعلية
        $totalUnits = 0;
        foreach ($enrollments as $enrollment) {
            $totalUnits += $enrollment->subjectOffer->subject->units;
        }

        // جلب الحد الأقصى للوحدات من الإعدادات
        $maxUnits = config('academic.unit_limits.max_units_per_semester', 18);
        $availableUnits = max(0, $maxUnits - $totalUnits);

        // جلب المواد المتاحة للتسجيل
        $availableSubjects = $this->getAvailableSubjects($user, $registeredSemester);

        return view('Student.semDetails.currentSem', [
            'currentSemester' => $registeredSemester,
            'enrollments' => $enrollments,
            'totalUnits' => $totalUnits,
            'maxUnits' => $maxUnits,
            'availableUnits' => $availableUnits,
            'availableSubjects' => $availableSubjects,
            'currentSemesterNumber' => $currentSemesterNumber,
            'enrollmentOpen' => $registeredSemester ? $registeredSemester->enrollment_open : false,
        ]);
    }

    /**
     * عرض صفحة المواد المتاحة للتسجيل
     */
    public function availableSubjects()
    {
        $user = Auth::user();

        // البحث عن الفصل الذي سجل فيه الطالب
        $registeredSemester = $this->getStudentRegisteredSemester($user);
        $currentSemesterNumber = SemesterStart::where('student_id', $user->id)->count();


        if (!$registeredSemester) {
            return view('Student.semDetails.add', [
                'currentSemester' => null,
                'availableSubjects' => collect(),
                'totalUnits' => 0,
                'maxUnits' => config('academic.unit_limits.max_units_per_semester', 18),
                'availableUnits' => 0,
                'hasRegistration' => false,
                'message' => 'يجب عليك التسجيل في فصل دراسي أولاً قبل تسجيل المواد',
                'currentSemesterNumber' => $currentSemesterNumber,
                'enrollmentOpen' => false,
            ]);
        }

        // التحقق من أن التسجيل في المواد مفتوح
        $enrollmentOpen = $registeredSemester->enrollment_open;
        if (!$enrollmentOpen) {
            return view('Student.semDetails.add', [
                'currentSemester' => $registeredSemester,
                'availableSubjects' => collect(),
                'totalUnits' => $user->getCurrentSemesterUnits(),
                'maxUnits' => config('academic.unit_limits.max_units_per_semester', 18),
                'availableUnits' => 0,
                'hasRegistration' => true,
                'message' => 'التسجيل في المواد مغلق حالياً لهذا الفصل',
                'enrollmentOpen' => false,
            ]);
        }

        // حساب الوحدات الحالية والمتاحة
        $totalUnits = $user->getCurrentSemesterUnits();
        $maxUnits = config('academic.unit_limits.max_units_per_semester', 18);
        $availableUnits = max(0, $maxUnits - $totalUnits);

        // جلب المواد المتاحة للتسجيل
        $availableSubjects = $this->getAvailableSubjects($user, $registeredSemester);

        return view('Student.semDetails.add', [
            'currentSemester' => $registeredSemester,
            'availableSubjects' => $availableSubjects,
            'totalUnits' => $totalUnits,
            'maxUnits' => $maxUnits,
            'availableUnits' => $availableUnits,
            'hasRegistration' => true,
            'message' => null,
            'enrollmentOpen' => $enrollmentOpen
        ]);
    }

    /**
     * الحصول على الفصل الذي سجل فيه الطالب
     */
    private function getStudentRegisteredSemester($user)
    {
        // البحث عن الفصل الذي سجل فيه الطالب (من جدول SemesterStart)
        $semesterStart = SemesterStart::where('student_id', $user->id)
            ->whereHas('semester', function($query) {
                // البحث عن الفصل النشط فقط
                $query->where('is_active', true);
            })
            ->with('semester')
            ->orderBy('created_at', 'desc')
            ->first();

        return $semesterStart ? $semesterStart->semester : null;
    }

    /**
     * جلب المواد المتاحة للطالب للتسجيل (المتاحة فقط)
     */
    private function getAvailableSubjects($user, $currentSemester)
    {
        // جلب جميع المواد المعروضة في الفصل الحالي
        $allSubjects = SubjectOffer::where('semester_id', $currentSemester->id)
            ->with(['subject.prerequisite', 'teacher'])
            ->get();

        // جلب المواد المسجل فيها بالفعل
        $enrolledSubjectOfferIds = Enrollment::where('student_id', $user->id)
            ->pluck('subject_offer_id')
            ->toArray();

        // استبعاد المواد المسجل فيها بالفعل
        $notEnrolledSubjects = $allSubjects->whereNotIn('id', $enrolledSubjectOfferIds);

        // تصفية المواد لعرض المتاحة فقط
        $availableSubjects = $notEnrolledSubjects->filter(function($subjectOffer) use ($user) {
            $subject = $subjectOffer->subject;

            // التحقق من المتطلب السابق
            if ($subject->prerequisite_subject_id) {
                $hasPrerequisite = $this->hasPassedPrerequisite($user, $subject->prerequisite_subject_id);
                if (!$hasPrerequisite) {
                    return false; // لا تعرض المادة إذا لم يجتز المتطلب
                }
            }

            // التحقق من الوحدات المتاحة
            $currentUnits = $user->getCurrentSemesterUnits();
            $maxUnits = config('academic.unit_limits.max_units_per_semester', 18);
            $availableUnits = $maxUnits - $currentUnits;

            if ($availableUnits < $subject->units) {
                return false; // لا تعرض المادة إذا تجاوزت الحد الأقصى
            }

            // إضافة معلومات الحالة (متاح دائماً هنا)
            $subjectOffer->enrollment_status = 'available';
            $subjectOffer->status_message = 'متاح للتسجيل';

            return true; // اعرض المادة
        });

        return $availableSubjects;
    }

    /**
     * التحقق من اجتياز المتطلب السابق - نسخة مبسطة
     */
    private function hasPassedPrerequisite($user, $prerequisiteSubjectId)
    {
        // جلب الدرجة لهذا المتطلب
        $gradeRecord = GradeRecord::whereHas('enrollment', function($query) use ($user, $prerequisiteSubjectId) {
            $query->where('student_id', $user->id)
                ->whereHas('subjectOffer.subject', function($subQuery) use ($prerequisiteSubjectId) {
                    $subQuery->where('id', $prerequisiteSubjectId);
                });
        })->first();

        if (!$gradeRecord) {
            return false; // لم يسجل في المادة أساساً
        }

        $minGrade = config('academic.prerequisites.minimum_grade_for_prerequisite', 60);
        return $gradeRecord->grade >= $minGrade;
    }
}
