<?php

namespace App\Http\Controllers\Student;

use App\Models\Semester;
use App\Models\Enrollment;
use App\Models\GradeRecord;
use App\Models\SubjectOffer;
use Illuminate\Http\Request;
use App\Models\SemesterStart;
use App\Models\SubjectRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubjectEnrollmentController extends Controller
{
    /**
     * تسجيل طالب في مادة
     */
    public function enrollInSubject(Request $request)
    {
        $request->validate([
            'subject_offer_id' => 'required|exists:subject_offers,id'
        ]);

        $user = Auth::user();
        $subjectOffer = SubjectOffer::with('subject', 'semester')->findOrFail($request->subject_offer_id);

        // التحقق من أن الطالب مسجل في هذا الفصل
        $registeredSemester = $this->getStudentRegisteredSemester($user);

        if (!$registeredSemester) {
            return response()->json([
                'success' => false,
                'message' => 'يجب عليك التسجيل في فصل دراسي أولاً'
            ]);
        }

        // التحقق من أن المادة تنتمي للفصل المسجل فيه الطالب
        if ($subjectOffer->semester_id !== $registeredSemester->id) {
            return response()->json([
                'success' => false,
                'message' => 'هذه المادة لا تنتمي للفصل المسجل فيه'
            ]);
        }

        // التحقق من أن التسجيل في المواد مفتوح
        if (!$registeredSemester->enrollment_open) {
            return response()->json([
                'success' => false,
                'message' => 'التسجيل في المواد مغلق حالياً لهذا الفصل'
            ]);
        }

        // التحقق من أن الطالب لم يسجل في هذه المادة من قبل
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('subject_offer_id', $request->subject_offer_id)
            ->exists();

        if ($existingEnrollment) {
            return response()->json([
                'success' => false,
                'message' => 'أنت مسجل في هذه المادة بالفعل'
            ]);
        }

        // التحقق من الوحدات المتاحة
        if (!$user->canEnrollInUnits($subjectOffer->subject->units)) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن التسجيل في هذه المادة بسبب تجاوز الحد الأقصى للوحدات'
            ]);
        }

        // التحقق من المتطلبات السابقة
        if ($subjectOffer->subject->prerequisite_subject_id) {
            $hasPrerequisite = $this->hasPassedPrerequisite($user, $subjectOffer->subject->prerequisite_subject_id);
            if (!$hasPrerequisite) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب اجتياز المتطلب السابق للتسجيل في هذه المادة'
                ]);
            }
        }

        // تسجيل الطالب في المادة
        $enrollment = Enrollment::create([
            'student_id' => $user->id,
            'subject_offer_id' => $request->subject_offer_id,
            'enrolled_at' => now()
        ]);
        GradeRecord::create([
    'enrollment_id' => $enrollment->id,
    'grade' => 0
]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيلك في المادة بنجاح',
            'enrollment' => $enrollment->load('subjectOffer.subject')
        ]);
    }

    /**
     * تسجيل طالب في عدة مواد
     */
    public function enrollInMultipleSubjects(Request $request)
    {
        $request->validate([
            'subject_offer_ids' => 'required|array',
            'subject_offer_ids.*' => 'required|exists:subject_offers,id'
        ]);

        $user = Auth::user();
        $subjectOfferIds = $request->subject_offer_ids;

        // التحقق من أن الطالب مسجل في فصل دراسي
        $registeredSemester = $this->getStudentRegisteredSemester($user);

        if (!$registeredSemester) {
            return response()->json([
                'success' => false,
                'message' => 'يجب عليك التسجيل في فصل دراسي أولاً'
            ]);
        }

        // التحقق من أن التسجيل في المواد مفتوح
        if (!$registeredSemester->enrollment_open) {
            return response()->json([
                'success' => false,
                'message' => 'التسجيل في المواد مغلق حالياً لهذا الفصل'
            ]);
        }

        // جلب جميع المواد المحددة
        $subjectOffers = SubjectOffer::with('subject', 'semester')
            ->whereIn('id', $subjectOfferIds)
            ->get();

        // التحقق من أن جميع المواد تنتمي للفصل المسجل فيه الطالب
        foreach ($subjectOffers as $subjectOffer) {
            if ($subjectOffer->semester_id !== $registeredSemester->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'بعض المواد لا تنتمي للفصل المسجل فيه'
                ]);
            }
        }

        // حساب إجمالي الوحدات المطلوبة
        $totalUnitsRequired = $subjectOffers->sum(function($offer) {
            return $offer->subject->units;
        });

        // التحقق من الوحدات المتاحة
        if (!$user->canEnrollInUnits($totalUnitsRequired)) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن التسجيل في هذه المواد بسبب تجاوز الحد الأقصى للوحدات'
            ]);
        }

        $errors = [];
        $successfulEnrollments = [];

        DB::beginTransaction();

        try {
            foreach ($subjectOffers as $subjectOffer) {
                // التحقق من أن الطالب لم يسجل في هذه المادة من قبل
                $existingEnrollment = Enrollment::where('student_id', $user->id)
                    ->where('subject_offer_id', $subjectOffer->id)
                    ->exists();

                if ($existingEnrollment) {
                    $errors[] = "أنت مسجل في مادة {$subjectOffer->subject->name} بالفعل";
                    continue;
                }

                // التحقق من المتطلبات السابقة
                if ($subjectOffer->subject->prerequisite_subject_id) {
                    $hasPrerequisite = $this->hasPassedPrerequisite($user, $subjectOffer->subject->prerequisite_subject_id);
                    if (!$hasPrerequisite) {
                        $errors[] = "يجب اجتياز المتطلب السابق للتسجيل في مادة {$subjectOffer->subject->name}";
                        continue;
                    }
                }

                // تسجيل الطالب في المادة
                $enrollment = Enrollment::create([
                    'student_id' => $user->id,
                    'subject_offer_id' => $subjectOffer->id,
                    'enrolled_at' => now()
                ]);
                    GradeRecord::create([
                    'enrollment_id' => $enrollment->id,
                 'grade' => 0 // or null, if column allows nulls
                 ]);

                $successfulEnrollments[] = $enrollment->load('subjectOffer.subject');
            }

            DB::commit();

            $message = 'تم تسجيلك في ' . count($successfulEnrollments) . ' مادة بنجاح';
            if (!empty($errors)) {
                $message .= "\n\nأخطاء:\n" . implode("\n", $errors);
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'enrollments' => $successfulEnrollments,
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التسجيل: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * إسقاط مادة مباشرة
     */
    public function dropSubject(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id'
        ]);

        $user = Auth::user();
        $enrollment = Enrollment::where('id', $request->enrollment_id)
            ->where('student_id', $user->id)
            ->with('subjectOffer.subject', 'subjectOffer.semester')
            ->firstOrFail();

        // التحقق من أن إسقاط المواد مسموح
        if (!$enrollment->subjectOffer->semester->enrollment_open) {
            return response()->json([
                'success' => false,
                'message' => 'إسقاط المواد مغلق حالياً لهذا الفصل'
            ]);
        }

        // التحقق من الموعد النهائي للإسقاط
        $dropDeadline = $enrollment->subjectOffer->semester->start_date
            ->addDays(config('academic.enrollment.drop_deadline_days', 30));

        if (now()->greaterThan($dropDeadline)) {
            return response()->json([
                'success' => false,
                'message' => 'انتهى الموعد النهائي لإسقاط المواد. كان الموعد النهائي: ' . $dropDeadline->format('Y-m-d')
            ]);
        }

        // حفظ سجل الإسقاط للتاريخ (بدون سبب)
        SubjectRequest::create([
            'student_id' => $user->id,
            'enrollment_id' => $request->enrollment_id,
            'request_type' => 'drop',
            'reason' => 'إسقاط مادة من قبل الطالب',
            'status' => 'approved',
            'requested_at' => now(),
            'processed_at' => now()
        ]);

        // حذف التسجيل مباشرة
        $subjectName = $enrollment->subjectOffer->subject->name;
        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => "تم إسقاط مادة '{$subjectName}' بنجاح"
        ]);
    }

    /**
     * التحقق من اجتياز المتطلب السابق
     */
    private function hasPassedPrerequisite($user, $prerequisiteSubjectId)
    {
        $minGrade = config('academic.prerequisites.minimum_grade_for_prerequisite', 60);

        $passed = \App\Models\GradeRecord::whereHas('enrollment', function($query) use ($user, $prerequisiteSubjectId) {
            $query->where('student_id', $user->id)
                ->whereHas('subjectOffer', function($subQuery) use ($prerequisiteSubjectId) {
                    $subQuery->where('subject_id', $prerequisiteSubjectId);
                });
        })
        ->where('grade', '>=', $minGrade)
        ->exists();

        return $passed;
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
}
