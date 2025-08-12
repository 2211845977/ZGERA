@extends('layouts.app')

@section('title', 'Instrument List')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إدارة الأدوات / الأجهزة</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الأجهزة</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Alerts -->
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Card -->
            <div class="card card-primary card-outline">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">قائمة الأدوات / الأجهزة</h3>
                    <a href="{{ route('instruments.create') }}" class="btn btn-primary ml-auto">
                        <i class="fas fa-plus"></i> إضافة أداة جديدة
                    </a>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الرقم التسلسلي</th>
                                <th>الحالة</th>
                                <th>الغرض</th>
                                <th>الوصف</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($instruments as $instrument)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $instrument->name }}</td>
                                    <td>{{ $instrument->serial_number }}</td>
                                    <td>
                                        @if ($instrument->status == 'active')
                                            <span class="badge badge-success">نشط</span>
                                        @elseif ($instrument->status == 'maintenance')
                                            <span class="badge badge-warning">صيانة</span>
                                        @else
                                            <span class="badge badge-danger">خارج الخدمة</span>
                                        @endif
                                    </td>
                                    <td>{{ $instrument->purpose }}</td>
                                    <td>{{ Str::limit($instrument->description, 50) }}</td>
                                    <td>
                                        <a href="{{ route('instruments.edit', $instrument->id) }}" class="btn btn-sm btn-info" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('instruments.destroy', $instrument->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">لا توجد أدوات مسجلة حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
