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
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">إضافة مادة دراسية</h3>
                                </div>

                                <form action="{{ route('admin.subjects.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="name">اسم المادة</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="أدخل اسم المادة" required>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label for="prerequisite_subject_id">المادة السابقة (اختياري)</label>
                                        <select class="form-control" id="prerequisite_subject_id" name="prerequisite_subject_id">
                                            <option value="" selected>لا توجد مادة سابقة</option>
                                            @foreach($subjects as $subjectOption)
                                                <option value="{{ $subjectOption->id }}">{{ $subjectOption->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- الفصل الدراسي -->
                                    <div class="form-group">
                                        <label for="semester">الفصل الدراسي</label>
                                        <select class="form-control" id="semester" name="semester" required>
                                            <option value="" disabled selected>اختر الفصل</option>
                                            <option value="الأول">الأول</option>
                                            <option value="الثاني">الثاني</option>
                                            <option value="الثالت">الثالت</option>
                                            <option value="الرابع">الرابع</option>
                                            <option value="الخامس">الخامس</option>
                                            <option value="السادس">السادس</option>
                                            <option value="السابع">السابع</option>
                                            <option value="الثامن">الثامن</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">إلغاء</a>
                                </div>
                            </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
    <!-- Main content -->
    
    <!-- /.content -->

@endsection