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
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- جدول الامتحانات -->
            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-center text-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calendar-alt ml-1"></i>
                        جدول الامتحانات - {{ $activeSemester ? $activeSemester->name : 'لا يوجد فصل نشط' }}
                    </h3>
                </div>

                <div class="card-body">



                    <!-- الجدول -->
                    <table class="table table-bordered text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>الفترة الرابعة</th>
                                <th>الفترة الثالثة</th>
                                <th>الفترة الثانية</th>
                                <th>الفترة الأولى</th>
                                <th>اليوم والتاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matrix as $date => $row)
                                <tr>
                                    <td>{{ $row['session4'] }}</td>
                                    <td>{{ $row['session3'] }}</td>
                                    <td>{{ $row['session2'] }}</td>
                                    <td>{{ $row['session1'] }}</td>
                                    <td><strong>({{ $row['day_number'] }})</strong>
                                        {{ \Carbon\Carbon::parse($date)->locale('ar')->translatedFormat('l Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- تذييل البطاقة -->
                <div class="card-footer text-muted">
                    <small>آخر تحديث:
                        <?= date('Y-m-d') ?>
                    </small>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->

    <!-- /.content -->

@endsection