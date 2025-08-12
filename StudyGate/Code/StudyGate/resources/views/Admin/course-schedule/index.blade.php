@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">جدول المحاضرات</h1>
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
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">جدول المحاضرات</h3>
                    <a href="{{route(name: 'admin.course-schedule.create')}}" class="btn btn-sm float-right"
                        style="background-color: #7ecf68; color: white; font-weight: bold; border: none;">
                        <i class="fas fa-plus"></i> إضافة محاضرة
                    </a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>اسم المادة</th>
                                <th>اسم المحاضر</th>
                                <th>اليوم</th>
                                <th>الفترة</th>
                                <th>القاعة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->id }}</td>
                                    <td>{{ $schedule->subjectOffer->subject->name ?? 'غير معروف' }}</td>
                                    <td>{{ $schedule->subjectOffer->teacher->name ?? 'غير معروف' }}</td>
                                    <td>{{ $schedule->day_of_week }}</td>
                                    <td>{{ $schedule->session }}</td>
                                    <td>{{ $schedule->room }}</td>
                                    <td>
                                        <a href="{{ route('admin.course-schedule.edit', $schedule->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        <form action="{{ route('admin.course-schedule.destroy', $schedule->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذه المحاضرة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if($schedules->isEmpty())
                                <tr>
                                    <td colspan="7">لا توجد محاضرات لعرضها.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->

    <!-- /.content -->

@endsection