<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\Lab;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $instruments = Instrument::all();
    return view('instruments.index', compact('instruments'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $labs = Lab::all();
        return view('instruments.create', compact('labs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'description' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'model' => 'nullable|string',
            'experiment_types' => 'nullable|string',
            'analysis_types' => 'nullable|string',
            'status' => 'required|string|in:active,maintenance,out_of_order',
            'required_materials' => 'nullable|string',
            'responsible_person' => 'nullable|string',
            'lab_id' => 'nullable|exists:labs,id',
        ]);

        Instrument::create($validated);

        return redirect()->route('instruments.index')->with('success', 'تمت إضافة الأداة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $instrument = Instrument::with('lab')->findOrFail($id);
        return view('instruments.show', compact('instrument'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $instrument = Instrument::findOrFail($id);
        $labs = Lab::all();
        return view('instruments.edit', compact('instrument', 'labs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $instrument = Instrument::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'description' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'model' => 'nullable|string',
            'experiment_types' => 'nullable|string',
            'analysis_types' => 'nullable|string',
           'status' => 'required|string|in:active,maintenance,out_of_order',
            'required_materials' => 'nullable|string',
            'responsible_person' => 'nullable|string',
            'lab_id' => 'nullable|exists:labs,id',
        ]);

        $instrument->update($validated);

        return redirect()->route('instruments.index')->with('success', 'تم تحديث الأداة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $instrument = Instrument::findOrFail($id);
        $instrument->delete();

        return redirect()->route('instruments.index')->with('success', 'تم حذف الأداة بنجاح');
    }
}
