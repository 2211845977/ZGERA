<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Instrument;
use App\Models\Lab;
use App\Models\Building;
use App\Models\Campus;

class DashboardController extends Controller
{
    //
    public function index()
{
    $totalUsers = User::count();
    $totalBookings = Booking::count();
    $totalInstruments = Instrument::count();
    $totalLabs = Lab::count();

    return view('dashboard.index', compact('totalUsers', 'totalBookings', 'totalInstruments', 'totalLabs'));
}

}
