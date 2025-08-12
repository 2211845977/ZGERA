<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    // عرض كل الأساتذة
    public function index()
    {
        $teachers = User::where('role', 'teacher')->latest()->paginate(50); // عرض 50 معلم في الصفحة
        return view('admin.Teachers.index', compact('teachers'));
    }

    // عرض نموذج إضافة أستاذ
    public function create()
    {
        return view('admin.Teachers.create');
    }

    // حفظ أستاذ جديد
    public function store(Request $request)
    {
        try {
            // التحقق من صحة البيانات المدخلة
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'id_number' => 'required|string|max:50|unique:users,id',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
            ]);

            // إنشاء حساب الأستاذ مع استخدام الرقم التعريفي ككلمة مرور
            $teacher = User::create([
                'id' => $validatedData['id_number'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'password' => bcrypt($validatedData['id_number']), // استخدام الرقم التعريفي ككلمة مرور
                'role' => 'teacher',
            ]);

            return redirect()->route('admin.teachers.index')
                ->with('success', 'تمت إضافة الأستاذ بنجاح');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء إضافة الأستاذ: ' . $e->getMessage());
        }
    }

    // عرض أستاذ معيّن
    public function show($id)
    {
        
    }

    // عرض نموذج التعديل
    public function edit(string $id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);
        return view('admin.Teachers.edit', compact('teacher'));
    }

    // تحديث بيانات أستاذ
    public function update(Request $request, string $id)
    {
        // التحقق من صحة البيانات المدخلة
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        try {
            // البحث عن المعلم المطلوب
            $teacher = User::where('role', 'teacher')->findOrFail($id);
            
            // تحديث البيانات الأساسية
            $teacher->name = $request->name;
            $teacher->id = $request->id_number; // تحديث الرقم التعريفي
            $teacher->email = $request->email;
            $teacher->phone_number = $request->phone_number;
            $teacher->address = $request->address;

            // حفظ التغييرات
            $teacher->save();

            return redirect()->route('admin.teachers.index')
                ->with('success', 'تم تحديث بيانات المعلم بنجاح');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث بيانات المعلم: ' . $e->getMessage());
        }
    }

    // حذف أستاذ
    public function destroy(string $id)
    {
        try {
            // التأكد من أن المعرف صحيح
            if (!is_numeric($id)) {
                return redirect()->route('admin.teachers.index')
                    ->with('error', 'معرف المعلم غير صالح');
            }
            
            // البحث عن المعلم مع التأكد من أنه معلم
            $teacher = User::where('id', $id)
                         ->where('role', 'teacher')
                         ->firstOrFail();
            
            $teacher->delete();
            
            return redirect()->route('admin.teachers.index')
                ->with('success', 'تم حذف المعلم بنجاح');
                
        } catch (\Exception $e) {
            \Log::error('Error in TeacherController@destroy - ID: ' . $id . ' - Error: ' . $e->getMessage());
            return redirect()->route('admin.teachers.index')
                ->with('error', 'حدث خطأ أثناء حذف المعلم: ' . $e->getMessage());
        }
    }
}
