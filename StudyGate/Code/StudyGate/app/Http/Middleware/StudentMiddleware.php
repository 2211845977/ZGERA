<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // التحقق من تسجيل الدخول
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        // التحقق من أن المستخدم طالب
        if (Auth::user()->role !== 'student') {
            return redirect()->back()->with('error', 'غير مصرح لك بالوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}