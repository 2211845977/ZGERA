@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">تعديل محاضرة</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.course-schedule.update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="subject_offer_id">المادة والمحاضر</label>
                            <select name="subject_offer_id" class="form-control" required>
                                <option value="">-- اختر --</option>
                                @foreach($subjectOffers as $offer)
                                    <option value="{{ $offer->id }}" {{ $schedule->subject_offer_id == $offer->id ? 'selected' : '' }}>
                                        {{ $offer->subject->name ?? '??' }} - {{ $offer->teacher->name ?? '??' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="day_of_week">اليوم</label>
                            <select name="day_of_week" class="form-control" required>
                                <option value="Sunday" {{ $schedule->day_of_week == 'Sunday' ? 'selected' : '' }}>الأحد
                                </option>
                                <option value="Monday" {{ $schedule->day_of_week == 'Monday' ? 'selected' : '' }}>الإثنين
                                </option>
                                <option value="Tuesday" {{ $schedule->day_of_week == 'Tuesday' ? 'selected' : '' }}>الثلاثاء
                                </option>
                                <option value="Wednesday" {{ $schedule->day_of_week == 'Wednesday' ? 'selected' : '' }}>
                                    الأربعاء</option>
                                <option value="Thursday" {{ $schedule->day_of_week == 'Thursday' ? 'selected' : '' }}>الخميس
                                </option>
                                <option value="Friday" {{ $schedule->day_of_week == 'Friday' ? 'selected' : '' }}>الجمعة
                                </option>
                                <option value="Saturday" {{ $schedule->day_of_week == 'Saturday' ? 'selected' : '' }}>السبت
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="session">الفترة</label>
                            <select class="form-control" name="session" required>
                                <option value="">-- اختر الفترة --</option>
                                <option value="session1" {{ $schedule->session == 'session1' ? 'selected' : '' }}>الفترة
                                    الأولى</option>
                                <option value="session2" {{ $schedule->session == 'session2' ? 'selected' : '' }}>الفترة
                                    الثانية</option>
                                <option value="session3" {{ $schedule->session == 'session3' ? 'selected' : '' }}>الفترة
                                    الثالثة</option>
                                    <option value="session4" {{ $schedule->session == 'session4' ? 'selected' : '' }}>الفترة
                                    الرابعة</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="room">القاعة</label>
                            <input type="text" name="room" class="form-control" value="{{ $schedule->room }}" required>
                        </div>

                        <button type="submit" class="btn btn-success">تحديث</button>
                        <a href="{{ route('admin.course-schedule.index') }}" class="btn btn-secondary">إلغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection