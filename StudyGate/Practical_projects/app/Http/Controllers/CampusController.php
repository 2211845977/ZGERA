<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Campus;  


class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campuses = Campus::all();
        return view('campus.index', compact('campuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('campus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Campus::create([
            'name' => $request->name,
        ]);

        return redirect()->route('campuses.index')->with('success', 'Campus created successfully.');
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
    public function edit(Campus $campus)
    {
        return view('campus.edit', compact('campus'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campus $campus)
{
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $campus->update([
            'name' => $request->name,
        ]);

        return redirect()->route('campuses.index')->with('success', 'Campus updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $campus = Campus::findOrFail($id);
    $campus->delete();
    return redirect()->route('campuses.index')->with('success', 'Campus deleted successfully.');
}
}
