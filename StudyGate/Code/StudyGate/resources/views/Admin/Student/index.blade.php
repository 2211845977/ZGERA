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
                            <h3 class="card-title">بيانات الطلبة</h3>
                            <a href="{{ route('admin.student.create') }}" class="btn btn-sm float-right" style="background-color: #7ecf68; color: white; font-weight: bold; border: none;">
                                <i class="fas fa-plus"></i>
                                إضافة طالب
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>الاسم</th>
                                        <th>رقم القيد</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>رقم الهاتف</th>
                                        <th>عنوان السكن</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->phone_number ?? 'غير محدد' }}</td>
                                        <td>{{ $student->address ?? 'غير محدد' }}</td>
                                        <td>
                                            <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> تعديل</a>
                                            <form action="{{ route('admin.student.destroy', $student->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')"><i class="fas fa-trash"></i> حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">لا توجد بيانات متاحة</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </section>

    <!-- Main content -->
    
    <!-- /.content -->

@endsection