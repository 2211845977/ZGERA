@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

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
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">تعديل بيانات الامتحان</h3>
                </div>
                <form action="{{ route('admin.exam-schedule.update', $exam->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- عمود اليمين -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>اسم المادة</label>
                                    <select class="form-control" name="subject_offer_id" required>
                                        <option value="" disabled>اختر المادة</option>
                                        @foreach($subject_offers as $offer)
                                            <option value="{{ $offer->id }}" {{ $exam->subject_offer_id == $offer->id ? 'selected' : '' }}>
                                                {{ $offer->subjectInfo->name ?? $offer->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_offer_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>تاريخ الامتحان</label>
                                    <input type="date" class="form-control" name="exam_date" required
                                        value="{{ old('exam_date', $exam->exam_date) }}">
                                    @error('exam_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- عمود اليسار -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نوع الامتحان</label>
                                    <select class="form-control" name="exam_type" required>
                                        <option value="" disabled>اختر نوع الامتحان</option>
                                        <option value="midterm" {{ old('exam_type', $exam->exam_type) == 'midterm' ? 'selected' : '' }}>نصفي</option>
                                        <option value="final" {{ old('exam_type', $exam->exam_type) == 'final' ? 'selected' : '' }}>نهائي</option>
                                    </select>
                                    @error('exam_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>الفترة</label>
                                    <select class="form-control" name="session" required>
                                        <option value="" >-- اختر الفترة --</option>
                                        <option value="session1" >الفترة الأولى</option>
                                        <option value="session2" >الفترة الثانية</option>
                                        <option value="session3" >الفترة الثالثة</option>
                                    </select>
                                    @error('session')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>القاعة</label>
                                    <input type="text" class="form-control" name="room" required
                                        value="{{ old('room', $exam->room) }}">
                                    @error('room')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning btn">تحديث</button>
                        <a href="{{ route('admin.exam-schedule.index') }}" class="btn btn-secondary">رجوع</a>
                    </div>
                </form>

            </div>
        </div>
    </section>
    <!-- Main content -->

    <!-- /.content -->

@endsection