@extends('layouts.app')

@section('content')
<div class="content-wrapper" >
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 text-left">
                    <h1> Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                        <li class="breadcrumb-item active">لوحة التحكم </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat boxes) -->
            <div class="row">

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalUsers ?? 0 }}</h3>
                            <p>عدد المستخدمين</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalBookings ?? 0 }}</h3>
                            <p>إجمالي الحجوزات</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <a href="{{ route('bookings.index') }}" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalInstruments ?? 0 }}</h3>
                            <p>عدد الأجهزة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <a href="{{ route('instruments.index') }}" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalLabs ?? 0 }}</h3>
                            <p>عدد المختبرات</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <a href="" class="small-box-footer">
                            المزيد <i class="fas fa-arrow-circle-left"></i>
                        </a>
                    </div>
                </div>

            </div>
            <!-- /.row -->

            <!-- Charts or other content can go here -->
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <!-- Example Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">مرحبا بك في لوحة التحكم</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="طي">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" title="إغلاق">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>يمكنك متابعة الإحصائيات الأساسية والوصول السريع إلى إدارات النظام من هنا.</p>
                        </div>
                    </div>
                </section>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
