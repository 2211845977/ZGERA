<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Notification;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();

        return view('admin.subjects.create',compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'prerequisite_subject_id' => 'nullable|exists:subjects,id',
            'semester' => 'required|string',
        ]);

        // إنشاء المادة
        $subject = Subject::create($validated);

        // إنشاء إشعار جديد
        Notification::create([
            'type' => 'lecture',
            'title' => 'تمت إضافة مادة جديدة',
            'body' => 'تمت إضافة مادة جديدة: ' . $subject->name .
                     ' في الفصل الدراسي: ' . $subject->semester .
                     ' بواسطة الإدارة.',
            'user_id' => null, // إشعار عام لجميع المعلمين
            'is_read' => false,
        ]);

        // Redirect to the subjects index with a success message
        return redirect()->route('admin.subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $subject = Subject::findOrFail($id);
        $subjects = Subject::where('id', '!=', $id)->get();
        return view('admin.subjects.edit', compact('subject', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
        'name' => 'required|string|max:100',
        'prerequisite_subject_id' => 'nullable|exists:subjects,id',
        'semester' => 'required|string',
    ]);

    $subject = Subject::findOrFail($id);
    $subject->update($validated);

    return redirect()->route('admin.subjects.index')->with('success', 'تم تحديث المادة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'تم حذف المادة بنجاح');
    }
}
