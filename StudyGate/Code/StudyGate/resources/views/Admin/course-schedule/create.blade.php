@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة محاضرة جديدة</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">إضافة محاضرة جديدة</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.course-schedule.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="subject_offer_id">المادة والمحاضر</label>
                            <select name="subject_offer_id" class="form-control" required>
                                <option value="">-- اختر --</option>
                                @foreach($subjectOffers as $offer)
                                    <option value="{{ $offer->id }}">
                                        {{ $offer->subject->name ?? '??' }} - {{ $offer->teacher->name ?? '??' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="day_of_week">اليوم</label>
                            <select name="day_of_week" class="form-control" required>
                                <option value="Sunday">الأحد</option>
                                <option value="Monday">الإثنين</option>
                                <option value="Tuesday">الثلاثاء</option>
                                <option value="Wednesday">الأربعاء</option>
                                <option value="Thursday">الخميس</option>
                                <option value="Friday">الجمعة</option>
                                <option value="Saturday">السبت</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="session">الفترة</label>
                            <select class="form-control" name="session" required>
                                <option value="">-- اختر الفترة --</option>
                                <option value="session1">الفترة الأولى</option>
                                <option value="session2">الفترة الثانية</option>
                                <option value="session3">الفترة الثالثة</option>
                                <option value="session4">الفترة الرابعه</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="room">القاعة</label>
                            <input type="text" name="room" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success">إضافة</button>
                        <a href="{{ route('admin.course-schedule.index') }}" class="btn btn-secondary">إلغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->

    <!-- /.content -->

@endsection