<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Instrument;

class BookingController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();
        return view('booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instruments = Instrument::all();
        return view('booking.create', compact('instruments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'instrument_id' => 'required|exists:instruments,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $user = \App\Models\User::firstOrCreate(['name' => $request->user_name], [
            'email' => $request->user_name . '@example.com',
            'password' => bcrypt('password')
        ]);

        $data = $request->all();
        $data['user_id'] = $user->id;
        unset($data['user_name']);

        Booking::create($data);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $instruments = \App\Models\Instrument::all();
        return view('booking.edit', compact('booking', 'instruments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'instrument_id' => 'required|exists:instruments,id',
            'user_name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        $user = \App\Models\User::firstOrCreate(['name' => $request->user_name], [
            'email' => $request->user_name . '@example.com',
            'password' => bcrypt('password')
        ]);
        $data = $request->all();
        $data['user_id'] = $user->id;
        unset($data['user_name']);
        $booking->update($data);
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
