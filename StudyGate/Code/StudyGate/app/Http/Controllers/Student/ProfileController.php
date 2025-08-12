<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the authenticated student's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // جلب إحصائيات الطالب
        $enrollmentsCount = \App\Models\Enrollment::where('student_id', $user->id)->count();
        
        // حساب إجمالي الوحدات
        $totalUnits = \App\Models\Enrollment::where('student_id', $user->id)
            ->with(['subjectOffer.subject'])
            ->get()
            ->sum(function($enrollment) {
                return $enrollment->subjectOffer->subject->units ?? 0;
            });
        
        // حساب المعدل العام
        $gradeRecords = \App\Models\GradeRecord::whereHas('enrollment', function($query) use ($user) {
            $query->where('student_id', $user->id);
        })->get();
        
        $averageGrade = $gradeRecords->count() > 0 
            ? round($gradeRecords->avg('grade'), 2) 
            : null;
        
        return view('Student.profile-student', compact(
            'user', 
            'enrollmentsCount', 
            'totalUnits', 
            'averageGrade'
        ));
    }

    /**
     * Show the form for editing the student's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('Student.edit-profile', compact('user'));
    }

    /**
     * Update the student's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:male,female',
            'birthdate' => 'nullable|date|before:today|after:1900-01-01',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|max:255|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
        ], [
            'name.required' => 'الاسم مطلوب',
            'name.regex' => 'الاسم يجب أن يحتوي على أحرف عربية فقط',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'phone_number.regex' => 'رقم الهاتف غير صحيح',
            'phone_number.max' => 'رقم الهاتف طويل جداً',
            'address.max' => 'العنوان طويل جداً',
            'gender.in' => 'الجنس غير صحيح',
            'birthdate.before' => 'تاريخ الميلاد يجب أن يكون في الماضي',
            'birthdate.after' => 'تاريخ الميلاد غير صحيح',
            'current_password.required_with' => 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور',
            'new_password.min' => 'كلمة المرور الجديدة يجب أن تكون 8 أحرف على الأقل',
            'new_password.max' => 'كلمة المرور طويلة جداً',
            'new_password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'new_password.regex' => 'كلمة المرور يجب أن تحتوي على حرف كبير وحرف صغير ورقم ورمز خاص',
        ]);

        // تحديث البيانات الأساسية
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->birthdate = $request->birthdate;

        // تحديث كلمة المرور إذا تم توفيرها
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('student.profile')->with('success', 'تم تحديث البيانات بنجاح');
    }
} 