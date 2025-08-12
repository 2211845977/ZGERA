@extends('layouts.app')

@section('title', 'إضافة حجز جديد')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة حجز جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">الحجوزات</a></li>
                        <li class="breadcrumb-item active">إضافة</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="content">
        <div class="container-fluid">

            <!-- Form Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">نموذج حجز أداة</h3>
                </div>

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <div class="card-body row">

                        <div class="form-group col-md-6">
                            <label for="user_name">اسم المستخدم</label>
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="أدخل اسم المستخدم" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="instrument_id">الأداة</label>
                            <select name="instrument_id" id="instrument_id" class="form-control" required>
                                <option value="">اختر أداة</option>
                                @foreach($instruments as $instrument)
                                    <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="start_time">تاريخ ووقت البداية</label>
                            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="end_time">تاريخ ووقت النهاية (اختياري)</label>
                            <input type="datetime-local" name="end_time" id="end_time" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status">الحالة</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="pending">قيد الانتظار</option>
                                <option value="confirmed">مقبول</option>
                                <option value="cancelled">ملغي</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> حفظ</button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
