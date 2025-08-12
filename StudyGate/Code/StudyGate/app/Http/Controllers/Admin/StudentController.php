<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // عرض كل الطلاب
    public function index()
    {
        $students = User::where('role', 'student')->latest()->get();
        return view('admin.Student.index', compact('students'));
    }

    // عرض نموذج إضافة طالب
    public function create()
    {
        return view('admin.Student.create');
    }

    // حفظ طالب جديد
    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'full_name' => 'required|string|max:255',
                'student_id' => 'required|string|max:50|unique:users,id',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
            ]);

            // إنشاء حساب الطالب مع استخدام رقم القيد ككلمة مرور
            $student = User::create([
                'id' => $validatedData['student_id'],
                'name' => $validatedData['full_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'password' => bcrypt($validatedData['student_id']), // استخدام رقم القيد ككلمة مرور
                'role' => 'student',
            ]);

            return redirect()->route('admin.student.index')
                ->with('success', 'تمت إضافة الطالب بنجاح');
                
        } catch (\Exception $e) {
            \Log::error('Error in StudentController@store - Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة الطالب: ' . $e->getMessage());
        }
    }

    // عرض طالب معيّن
    public function show($id)
    {
        
    }

    // عرض نموذج التعديل
    public function edit(string $id)
    {
        try {
            // التأكد من أن المعرف صحيح
            if (!is_numeric($id)) {
                return redirect()->route('admin.student.index')
                    ->with('error', 'معرف الطالب غير صالح');
            }
            
            // البحث عن الطالب مع التأكد من أنه طالب
            $student = User::where('id', $id)
                         ->where('role', 'student')
                         ->first();
            
            if (!$student) {
                return redirect()->route('admin.student.index')
                    ->with('error', 'الطالب غير موجود أو لا يوجد لديك صلاحية للوصول إليه');
            }
            
            return view('admin.Student.edit', compact('student'));
            
        } catch (\Exception $e) {
            \Log::error('Error in StudentController@edit - ID: ' . $id . ' - Error: ' . $e->getMessage());
            return redirect()->route('admin.student.index')
                ->with('error', 'حدث خطأ أثناء تحميل صفحة التعديل: ' . $e->getMessage());
        }
    }

    // تحديث بيانات طالب
    public function update(Request $request, string $id)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'phone_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'registration_number' => 'required|string|max:50|unique:users,id,' . $id,
                'birthdate' => 'nullable|date',
            ]);
            
            // تحديث المعرف إذا تم تغييره
            if ($request->registration_number != $id) {
                $user = User::find($id);
                $user->id = $request->registration_number;
                $user->save();
            }

            // البحث عن الطالب وتحديث بياناته
            $student = User::where('id', $id)
                         ->where('role', 'student')
                         ->firstOrFail();

            $student->update($validatedData);

            return redirect()->route('admin.student.index')
                ->with('success', 'تم تحديث بيانات الطالب بنجاح');
                
        } catch (\Exception $e) {
            \Log::error('Error in StudentController@update - ID: ' . $id . ' - Error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث بيانات الطالب: ' . $e->getMessage());
        }
    }

    // حذف طالب
    public function destroy(string $id)
    {
        try {
            // التأكد من أن المعرف صحيح
            if (!is_numeric($id)) {
                return redirect()->route('admin.student.index')
                    ->with('error', 'معرف الطالب غير صالح');
            }
            
            // البحث عن الطالب مع التأكد من أنه طالب
            $student = User::where('id', $id)
                         ->where('role', 'student')
                         ->firstOrFail();
            
            $student->delete();
            
            return redirect()->route('admin.student.index')
                ->with('success', 'تم حذف الطالب بنجاح');
                
        } catch (\Exception $e) {
            \Log::error('Error in StudentController@destroy - ID: ' . $id . ' - Error: ' . $e->getMessage());
            return redirect()->route('admin.student.index')
                ->with('error', 'حدث خطأ أثناء حذف الطالب: ' . $e->getMessage());
        }
    }
}
