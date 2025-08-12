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
                    <div class="card card-primary card-outline">

                        <!-- رأس الكارد -->
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title">إدارة المواد الدراسية</h3>
                            <a href="{{route("admin.subjects.create")}}" class="btn btn-primary ml-auto">
                                <i class="fas fa-plus"></i> إضافة مادة
                            </a>
                        </div>

                        <!-- جسم الكارد (الجدول) -->
                        <div class="card-body p-0">
                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>اسم المادة</th>
                                    <th>الفصل الدراسي</th> 
                                    <th>المادة السابقة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->semester ?? 'غير محدد' }}</td> <!-- عرض الفصل الدراسي -->
                                        <td>
                                            {{ $subject->prerequisite ? $subject->prerequisite->name : 'لا توجد' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.subjects.edit', $subject->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟');">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                    </div>
                </div>
            </section>
    <!-- Main content -->
    
    <!-- /.content -->

@endsection