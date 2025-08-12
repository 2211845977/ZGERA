@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
                <div class="container-fluid pt-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">بيانات الطالب</h3>
                        </div>
                        <form action="{{ route('admin.student.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- عمود اليمين -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>الاسم الكامل</label>
                                            <input type="text" class="form-control" name="full_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>رقم القيد</label>
                                            <input type="text" class="form-control" name="student_id" required>
                                        </div>
                                        <div class="form-group">
                                            <label>البريد الإلكتروني</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <!-- عمود اليسار -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>رقم الهاتف</label>
                                            <input type="tel" class="form-control" name="phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label>عنوان السكن</label>
                                            <textarea class="form-control" name="address" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                               <a href="{{ route('admin.student.index') }}" class="btn btn-default">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>


     <!-- Main content -->
    
    <!-- /.content -->

@endsection
