@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="direction: rtl;">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>تعديل حجز</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="user_name">اسم المستخدم</label>
                                    <input type="text" name="user_name" id="user_name" class="form-control" value="{{ $booking->user ? $booking->user->name : '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="instrument_id">الآلة</label>
                                    <select name="instrument_id" id="instrument_id" class="form-control" required>
                                        @foreach($instruments as $instrument)
                                            <option value="{{ $instrument->id }}" {{ $booking->instrument_id == $instrument->id ? 'selected' : '' }}>{{ $instrument->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_time">تاريخ ووقت البداية</label>
                                    <input type="datetime-local" name="start_time" id="start_time" class="form-control" value="{{ $booking->start_time ? date('Y-m-d\TH:i', strtotime($booking->start_time)) : '' }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="end_time">تاريخ ووقت النهاية (اختياري)</label>
                                    <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ $booking->end_time ? date('Y-m-d\TH:i', strtotime($booking->end_time)) : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="status">الحالة</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">إلغاء</a>
                                <button type="submit" class="btn btn-success">حفظ التعديلات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
