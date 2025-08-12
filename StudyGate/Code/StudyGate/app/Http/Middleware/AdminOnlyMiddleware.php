<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // السماح للأدمن فقط
        if (Auth::user()->role !== 'admin') {
            // إذا كان المستخدم معلم، إعادة توجيه إلى dashboard المعلم
            if (Auth::user()->role === 'teacher') {
                return redirect()->route('teacher.dashboard')
                    ->with('error', 'غير مصرح لك بالوصول إلى إدارة الطلبة. هذه الصلاحية مخصصة للإدارة فقط.');
            }
            
            // إذا كان المستخدم طالب، إعادة توجيه إلى صفحة الطالب
            if (Auth::user()->role === 'student') {
                return redirect()->route('student.profile')
                    ->with('error', 'غير مصرح لك بالوصول إلى هذه الصفحة');
            }
            
            // إعادة توجيه عامة للمستخدمين الآخرين
            return redirect()->back()->with('error', 'غير مصرح لك بالوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
} 