<?php

namespace App\Http\Controllers;

use App\Models\Lab;
use App\Models\Building;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        $labs = Lab::with('building')->get();
        return view('labs.index', compact('labs'));
    }

    public function create()
    {
        $buildings = Building::all();
        return view('labs.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        Lab::create($request->all());

        return redirect()->route('labs.index')->with('success', 'تم إضافة المختبر بنجاح');
    }

    public function show(Lab $lab)
    {
        return view('labs.show', compact('lab'));
    }

    public function edit(Lab $lab)
    {
        $buildings = Building::all();
        return view('labs.edit', compact('lab', 'buildings'));
    }

    public function update(Request $request, Lab $lab)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $lab->update($request->all());

        return redirect()->route('labs.index')->with('success', 'تم تحديث بيانات المختبر');
    }

    public function destroy(Lab $lab)
    {
        $lab->delete();

        return redirect()->route('labs.index')->with('success', 'تم حذف المختبر');
    }
}
