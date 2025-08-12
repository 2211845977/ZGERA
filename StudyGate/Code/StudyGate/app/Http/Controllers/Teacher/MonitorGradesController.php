<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\SubjectOffer;
use App\Models\GradeRecord;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonitorGradesController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();

        // الحصول على الفصل الحالي النشط
        $currentSemester = Semester::where('is_active', true)->first();

        if (!$currentSemester) {
            return view('teachers.monitor-grades.index', [
                'currentSemester' => null,
                'subjectOffers' => collect(),
                'selectedSubject' => null,
                'students' => collect(),
                'message' => 'لا يوجد فصل دراسي نشط حالياً'
            ]);
        }

        // جلب المواد المكلف بها المعلم في الفصل الحالي فقط
        $subjectOffers = $teacher->teachingSubjects()
            ->where('semester_id', $currentSemester->id)
            ->with(['subject', 'enrollments.student', 'enrollments.gradeRecord'])
            ->get();

        return view('teachers.monitor-grades.index', compact(
            'currentSemester',
            'subjectOffers'
        ));
    }

    public function showSubjectGrades($subjectOfferId)
    {
        $teacher = Auth::user();
        $currentSemester = Semester::where('is_active', true)->first();

        // التأكد من أن المادة تنتمي للمعلم وللفصل الحالي
        $subjectOffer = SubjectOffer::where('id', $subjectOfferId)
            ->where('teacher_id', $teacher->id)
            ->where('semester_id', $currentSemester->id)
            ->with(['subject', 'enrollments.student', 'enrollments.gradeRecord'])
            ->firstOrFail();

        // جلب الطلبة مع درجاتهم
        $students = $subjectOffer->enrollments()
            ->with(['student', 'gradeRecord'])
            ->get()
            ->map(function($enrollment) {
                $gradeRecord = $enrollment->gradeRecord;
                $totalGrade = 0;
                $grade = null;

                if ($gradeRecord) {
                    $totalGrade = ($gradeRecord->midterm_1 ?? 0) +
                                 ($gradeRecord->midterm_2 ?? 0) +
                                 ($gradeRecord->final_exam ?? 0);
                    $grade = $this->calculateGrade($totalGrade);
                }

                return [
                    'enrollment' => $enrollment,
                    'student' => $enrollment->student,
                    'gradeRecord' => $gradeRecord,
                    'totalGrade' => $totalGrade,
                    'grade' => $grade
                ];
            });

        // حساب الإحصائيات
        $stats = $this->calculateStats($students);

        return view('teachers.monitor-grades.subject-grades', compact(
            'currentSemester',
            'subjectOffer',
            'students',
            'stats'
        ));
    }

    public function updateGrade(Request $request, $enrollmentId)
{
    $teacher = Auth::user();

    // Validate input
    $request->validate([
        'midterm_1' => 'nullable|numeric|min:0|max:20',
        'midterm_2' => 'nullable|numeric|min:0|max:20',
        'final_exam' => 'nullable|numeric|min:0|max:60',
    ]);

    // Confirm enrollment belongs to this teacher
    $enrollment = Enrollment::whereHas('subjectOffer', function($query) use ($teacher) {
        $query->where('teacher_id', $teacher->id);
    })->findOrFail($enrollmentId);

    // Calculate total numeric grade
    $totalGrade = ($request->midterm_1 ?? 0) +
                  ($request->midterm_2 ?? 0) +
                  ($request->final_exam ?? 0);

    // Save only total numeric grade in 'grade' column
    GradeRecord::updateOrCreate(
        ['enrollment_id' => $enrollmentId],
        [
            'grade' => $totalGrade,
            // You can add 'updated_by' if that column exists
            // 'updated_by' => $teacher->id,
        ]
    );

    return response()->json(['success' => true, 'message' => 'تم تحديث الدرجات بنجاح']);
}

//-------------old update function -------------------------------
    // public function updateGrade(Request $request, $enrollmentId)
    // {
    //     $teacher = Auth::user();

    //     // التحقق من صحة البيانات
    //     $request->validate([
    //         'midterm_1' => 'nullable|numeric|min:0|max:20',
    //         'midterm_2' => 'nullable|numeric|min:0|max:20',
    //         'final_exam' => 'nullable|numeric|min:0|max:60',
    //     ]);

    //     // التأكد من أن التسجيل ينتمي للمعلم
    //     $enrollment = Enrollment::whereHas('subjectOffer', function($query) use ($teacher) {
    //         $query->where('teacher_id', $teacher->id);
    //     })->findOrFail($enrollmentId);

    //     // حساب المجموع الكلي
    //     $totalGrade = ($request->midterm_1 ?? 0) +
    //                  ($request->midterm_2 ?? 0) +
    //                  ($request->final_exam ?? 0);

    //     // حساب التقدير تلقائياً
    //     $letterGrade = $this->calculateGrade($totalGrade);

    //     // تحديث أو إنشاء سجل الدرجات
    //     GradeRecord::updateOrCreate(
    //         ['enrollment_id' => $enrollmentId],
    //         [
    //             'midterm_1' => $request->midterm_1,
    //             'midterm_2' => $request->midterm_2,
    //             'final_exam' => $request->final_exam,
    //             'total_grade' => $totalGrade,
    //             'letter_grade' => $letterGrade,
    //             'updated_by' => $teacher->id
    //         ]
    //     );

    //     return response()->json(['success' => true, 'message' => 'تم تحديث الدرجات بنجاح']);
    // }

    private function calculateGrade($totalGrade)
    {
        if ($totalGrade >= 95) return 'A+';
        if ($totalGrade >= 90) return 'A';
        if ($totalGrade >= 85) return 'B+';
        if ($totalGrade >= 80) return 'B';
        if ($totalGrade >= 75) return 'C+';
        if ($totalGrade >= 70) return 'C';
        if ($totalGrade >= 65) return 'D+';
        if ($totalGrade >= 60) return 'D';
        return 'F';
    }

    private function calculateStats($students)
    {
        $totalStudents = $students->count();
        $gradedStudents = $students->where('gradeRecord', '!=', null);

        $averageGrade = $gradedStudents->count() > 0
            ? round($gradedStudents->avg('totalGrade'), 1)
            : 0;

        $gradeDistribution = $gradedStudents->groupBy('grade')->map->count();

        return [
            'total_students' => $totalStudents,
            'graded_students' => $gradedStudents->count(),
            'average_grade' => $averageGrade,
            'grade_distribution' => $gradeDistribution
        ];
    }
}
