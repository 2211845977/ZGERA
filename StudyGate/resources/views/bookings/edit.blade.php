@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Booking</h1>

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="قيد الانتظار" {{ $booking->status == 'قيد الانتظار' ? 'selected' : '' }}>قيد الانتظار
                    </option>
                    <option value="مؤكد" {{ $booking->status == 'مؤكد' ? 'selected' : '' }}>مؤكد</option>
                    <option value="ملغي" {{ $booking->status == 'ملغي' ? 'selected' : '' }}>ملغي</option>
                </select>
            </div>

            <div class="form-group">
                <label for="user_name">User Name</label>
                <input type="text" name="user_name" id="user_name" class="form-control"
                    value="{{ optional($booking->user)->name }}" required>
            </div>
    </div>

    <button type="submit" class="btn btn-primary">Update Booking</button>
    </form>
    </div>
@endsection