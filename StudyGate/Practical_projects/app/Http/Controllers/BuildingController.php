<?php

namespace App\Http\Controllers;
use App\Models\Building;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Campus;
class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    
    $buildings = Building::with('campus')->get();
    return view('buildings.index', compact('buildings'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $campuses = Campus::all(); // لجلب كل الحُرُم الجامعية لاستخدامها في القائمة المنسدلة
        return view('buildings.create', compact('campuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'campus_id' => 'required|exists:campuses,id',
        ]);

        // إدراج المبنى
        Building::create([
            'name' => $request->name,
            'campus_id' => $request->campus_id,
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('buildings.index')->with('success', 'تمت إضافة المبنى بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $building = Building::findOrFail($id); // جلب المبنى المحدد
        $campuses = Campus::all(); // جلب جميع الحُرُم الجامعية لعرضها في القائمة المنسدلة
        return view('buildings.edit', compact('building', 'campuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $building = Building::findOrFail($id);

    $building->update([
        'name' => $request->name,
    ]);

    return redirect()->route('buildings.index')->with('success', 'تم تحديث بيانات المبنى بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $building = Building::findOrFail($id);
        $building->delete();

        return redirect()->route('buildings.index')->with('success', 'تم حذف المبنى بنجاح.');
    }
}
