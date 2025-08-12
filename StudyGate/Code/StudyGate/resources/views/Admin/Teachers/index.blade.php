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
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">بيانات الدكاترة</h3>
                            <a href="{{ route('admin.teachers.create') }}" class="btn btn-sm float-right" style="background-color: #7ecf68; color: white; font-weight: bold; border: none;">
                                <i class="fas fa-plus"></i>
                                إضافة دكتور 
                            </a>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الدكتور</th>
                                        <th>الرقم التعريفي</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>عنوان السكن</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teachers as $index => $teacher)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->id }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone_number }}</td>
                                        <td>{{ $teacher->address ?? 'غير محدد' }}</td>
                                        <td style="white-space: nowrap">
                                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المدرس؟')">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد سجلات للمدرسين</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>


    <!-- Main content -->
    
    <!-- /.content -->

@endsection