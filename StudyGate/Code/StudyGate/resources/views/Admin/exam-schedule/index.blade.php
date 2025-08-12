@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Of Exams</h1>
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
                    <h3 class="card-title">
                        جدول الامتحانات
                    </h3>
                    <a href="{{route('admin.exam-schedule.create')}}" class="btn btn-sm float-right"
                        style="background-color: #7ecf68; color: white; font-weight: bold; border: none;">
                        <i class="fas fa-plus"></i>
                        إضافة امتحان
                    </a>


                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>اسم المادة</th>
                                <th>نوع الامتحان</th>
                                <th>تاريخ الامتحان</th>
                                <th>الفترة</th>
                                <th>القاعة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($examschedule as $exam)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $exam->subjectOffer->subject->name ?? 'غير معروف' }}</td>
                                    <td>{{ $exam->exam_type }}</td>
                                    <td>{{ $exam->exam_date }}</td>
                                    <td>
                                        @if ($exam->session == 'session1')
                                            الفترة الأولى
                                        @elseif ($exam->session == 'session2')
                                            الفترة الثانية
                                        @elseif ($exam->session == 'session3')
                                            الفترة الثالثة
                                        @else
                                            غير معروفة
                                        @endif
                                    </td>

                                    <td>{{ $exam->room }}</td>
                                    <td>
                                        <a href="{{ route('admin.exam-schedule.edit', $exam->id) }}"
                                            class="btn btn-sm btn-primary">تعديل</a>
                                        <form action="{{ route('admin.exam-schedule.destroy', $exam->id) }}" method="POST"
                                            style="display:inline;">
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
    <!-- Main content -->

    <!-- /.content -->

@endsection