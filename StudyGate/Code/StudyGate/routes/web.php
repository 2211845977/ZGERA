<?php

use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\CourseScheduleController;
use App\Http\Controllers\Admin\ExamScheduleController;
use App\Http\Controllers\Student\ExamScheduleController as StudentExamScheduleController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\AuthController;

// Student Controllers
use App\Http\Controllers\Student\ClassScheduleController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\SemDetailsController;
use App\Http\Controllers\Student\CurrentSemesterController;
use App\Http\Controllers\Student\SemesterSubjectsController;
use App\Http\Controllers\Student\SemesterRegistrationController;
use App\Http\Controllers\Student\SubjectEnrollmentController;

// Teacher Controllers
use App\Http\Controllers\Teacher\AddStudentsCourseController;
use App\Http\Controllers\Teacher\NotificationsController;
use App\Http\Controllers\Teacher\TeacherProfileController;
use App\Http\Controllers\Teacher\SubjectsController;
use App\Http\Controllers\Teacher\SchedulesController;
use App\Http\Controllers\Teacher\MonitorGradesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;

//------------------------------------------------------
// Home Page
//------------------------------------------------------
Route::get('/', function () {
    return view('partials.login');
});

//------------------------------------------------------
// Authentication Routes
//------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//------------------------------------------------------
// Admin Routes
//------------------------------------------------------

// Dashboard
Route::get('admin/dashboard', [DashboardController::class, 'ShowDashboard'])->name('admin.dashboard');

// Semester
Route::get('admin/semester', [SemesterController::class, 'ShowSemester'])->name('semesters.index');
// Toggle enrollment status for a semester(able to enroll or not !)
Route::patch('/semesters/{id}/toggle-enrollment', [SemesterController::class, 'toggleEnrollment'])->name('semesters.toggleEnrollment');

//semester ->create
Route::get('admin/create', [SemesterController::class, 'ShowCreateSemester'])->name('semesters.create');
Route::Post('admin/semesters',[SemesterController::class,'store'])->name('semesters.store');

//------------------------------------------------------
// Assignments
//------------------------------------------------------
Route::get('/semesters/{semester}/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
Route::get('/semesters/{semester}/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
Route::post('/semesters/{semester}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

// Admin Resource Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/exam-schedule/matrix', [ExamScheduleController::class, 'showMatrix'])
    ->name('exam-schedule.matrix');
    Route::get('/course-schedule/matrix', [CourseScheduleController::class, 'showMatrix'])
    ->name('course-schedule.matrix');

    Route::resource('subjects', SubjectController::class);
    Route::resource('course-schedule', CourseScheduleController::class);
    Route::resource('exam-schedule', ExamScheduleController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('student', StudentController::class)->middleware('admin.only');
});

//------------------------------------------------------
// Student Routes (with Student Middleware)
//------------------------------------------------------
Route::prefix('student')->name('student.')->middleware('student')->group(function () {

    // Class Schedules - جدول المحاضرات
    Route::get('/course-schedule', [ClassScheduleController::class, 'ShowClassSchedules'])
        ->name('course-schedule');

    // Exam Schedules - جدول الامتحانات
    Route::get('/exam-schedule', [StudentExamScheduleController::class, 'index'])->name('exam-schedule');

    // Profile - الملف الشخصي
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Semester Details - تفاصيل الفصل الدراسي
    Route::get('/sem-details', [SemDetailsController::class, 'index'])->name('sem-details');

    // Current Semester (Enrolled Subjects) - الفصل الحالي
    Route::get('/current-sem', [CurrentSemesterController::class, 'index'])->name('current-sem');

    // Subject Enrollment and Drop - تسجيل وإسقاط المواد
    Route::post('/enroll-subject', [SubjectEnrollmentController::class, 'enrollInSubject'])->name('enroll-subject');
    Route::post('/enroll-multiple-subjects', [SubjectEnrollmentController::class, 'enrollInMultipleSubjects'])->name('enroll-multiple-subjects');
    Route::post('/drop-subject', [SubjectEnrollmentController::class, 'dropSubject'])->name('drop-subject');

    // Available Subjects Page - المواد المتاحة
    Route::get('/add-course', [CurrentSemesterController::class, 'availableSubjects'])->name('add-course');

    // Semester Subjects (API) - مواد الفصل الدراسي
    Route::get('/semester-subjects/{semesterId}', [SemesterSubjectsController::class, 'getSemesterSubjects'])->name('semester-subjects');

    // Semester Registration (API) - تسجيل الفصل الدراسي
    Route::post('/register-semester/{semesterId}', [SemesterRegistrationController::class, 'registerForSemester'])->name('register-semester');
});

//------------------------------------------------------
// Teacher Routes (with Teacher Middleware)
//------------------------------------------------------

Route::get('teacher/add-students-course', [AddStudentsCourseController::class, 'index'])->name('teacher.add-students-course')->middleware('admin.only');
Route::get('teacher/notifications', [NotificationsController::class, 'index'])->name('teacher.notifications');
Route::post('teacher/notifications/read/{id}', [NotificationsController::class, 'markAsRead'])->name('notifications.read');
Route::get('teacher/profile', [TeacherProfileController::class, 'index'])->name('teacher.profile');
Route::get('teacher/subjects', [SubjectsController::class, 'index'])->name('teacher.subjects');
Route::get('teacher/schedules', [SchedulesController::class, 'index'])->name('teacher.schedules');
Route::get('teacher/monitor-grades', [MonitorGradesController::class, 'index'])->name('teacher.monitor-grades');

Route::prefix('teacher')->name('teacher.')->middleware('teacher')->group(function () {

    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    Route::get('/subjects/{subjectOffer}/students', [SubjectsController::class, 'showStudents'])
        ->name('subject.students');
    Route::get('/add-students-course', [AddStudentsCourseController::class, 'index'])->name('add-students-course');

    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::delete('/notifications/delete-all', [NotificationsController::class, 'destroyAll'])->name('notifications.destroyAll');

    Route::get('/profile', [TeacherProfileController::class, 'index'])->name('profile');
    Route::get('/subjects', [SubjectsController::class, 'index'])->name('subjects');
    Route::get('/schedules', [SchedulesController::class, 'index'])->name('schedules');
    Route::get('/monitor-grades', [MonitorGradesController::class, 'index'])->name('monitor-grades');
    Route::get('/monitor-grades/subject/{subjectOffer}', [MonitorGradesController::class, 'showSubjectGrades'])->name('monitor-grades.subject');
    Route::put('/monitor-grades/update/{enrollment}', [MonitorGradesController::class, 'updateGrade'])->name('monitor-grades.update');
});

//------------------------------------------------------
// Users Management Routes
//------------------------------------------------------
Route::resource('users', UserController::class);
Route::get('users-search', [UserController::class, 'search'])->name('users.search');

