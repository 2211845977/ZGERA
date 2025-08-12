<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            // ...validation rules...
            'status' => 'required|string', // أضف تحقق للحالة
            // ...existing code...
        ]);

        $booking = new Booking();
        // ...existing code...
        $booking->status = $request->input('status'); // يجب أن تكون القيم متطابقة مع الفورم وقاعدة البيانات
        // ...existing code...
        $booking->save();
        // ...existing code...
    }
    // ...existing code...
}