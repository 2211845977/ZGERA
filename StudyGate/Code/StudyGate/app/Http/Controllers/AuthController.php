<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // الصفحة موجودة في resources/views/partials/login.blade.php
        return view('partials.login');
    }

    public function login(Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // توجه حسب الدور
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'student':
                    // توجيه الطالب إلى صفحة تفاصيل الفصل
                    return redirect()->route('student.sem-details');
                case 'teacher':
                    // توجه لواجهة المعلم الرئيسية، مثلا notifications أو data
                    return redirect()->route('teacher.dashboard');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'الدور غير معرف في النظام']);
            }
        }

        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
