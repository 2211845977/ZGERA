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
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">تعديل مادة دراسية</h3>
                    </div>

                    <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <!-- اسم المادة -->
                            <div class="form-group">
                                <label for="name">اسم المادة</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $subject->name) }}" required />
                            </div>

                            <!-- المادة السابقة -->
                            <div class="form-group">
                                <label for="prerequisite_subject_id">المادة السابقة (اختياري)</label>
                                <select class="form-control" id="prerequisite_subject_id" name="prerequisite_subject_id">
                                    <option value="">لا توجد مادة سابقة</option>
                                    @foreach($subjects as $subj)
                                        <option value="{{ $subj->id }}"
                                            {{ (old('prerequisite_subject_id', $subject->prerequisite_subject_id) == $subj->id) ? 'selected' : '' }}>
                                            {{ $subj->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- الفصل الدراسي -->
                            <div class="form-group">
                                <label for="semester">الفصل الدراسي</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="" disabled>اختر الفصل</option>
                                    <option value="الأول" {{ (old('semester', $subject->semester) == 'الأول') ? 'selected' : '' }}>الأول</option>
                                    <option value="الثاني" {{ (old('semester', $subject->semester) == 'الثاني') ? 'selected' : '' }}>الثاني</option>
                                </select>
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <button type="submit" class="btn btn-warning">تحديث</button>
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