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

            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-center text-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-calendar-alt ml-1"></i>
                        جدول المحاضرات  - {{ $activeSemester ? $activeSemester->name : 'لا يوجد فصل نشط' }}
                    </h3>
                </div>
                <div class="card-body">



                    <!-- الجدول -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center" id="examTable">
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
                                @foreach ($formatted as $day => $sessions)
                                    <tr>
                                        <td>{{ $sessions['session4'] }}</td>
                                        <td>{{ $sessions['session3'] }}</td>
                                        <td>{{ $sessions['session2'] }}</td>
                                        <td>{{ $sessions['session1'] }}</td>
                                        <td><strong>({{ $loop->iteration }})</strong> {{ $day }}</td>
                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>


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