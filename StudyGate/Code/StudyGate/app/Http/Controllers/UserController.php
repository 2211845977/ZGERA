<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Notifications\StudentRegistered;

class UserController extends Controller
{
    /**
     * عرض قائمة المستخدمين
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * عرض نموذج إنشاء مستخدم جديد
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * حفظ مستخدم جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher,admin',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:male,female',
            'birthdate' => 'nullable|date',
        ]);


        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
        ]);


        

        return redirect()->route('users.index')->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    /**
     * عرض تفاصيل مستخدم
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * عرض نموذج تعديل مستخدم
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * تحديث بيانات مستخدم
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:student,teacher,admin',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:male,female',
            'birthdate' => 'nullable|date',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    /**
     * حذف مستخدم
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح');
    }

    /**
     * البحث في المستخدمين
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $role = $request->get('role');

        $users = User::query();

        if ($query) {
            $users->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('phone_number', 'like', "%{$query}%");
            });
        }

        if ($role) {
            $users->where('role', $role);
        }

        $users = $users->paginate(10);

        return view('users.index', compact('users', 'query', 'role'));
    }
}