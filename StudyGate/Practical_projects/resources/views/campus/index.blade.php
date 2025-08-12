@extends('layouts.app')

@section('title', 'Campus List')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إدارة الحُرُم الجامعية</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الحُرُم الجامعية</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <!-- Card Header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">قائمة الحُرُم </h3>
                    <a href="{{ route('campuses.create') }}" class="btn btn-primary ml-auto">
                        <i class="fas fa-plus"></i> إضافة حرم
                    </a>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered table-hover text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>اسم الحرم</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campuses as $index => $campus)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $campus->name }}</td>
                                    <td>
                                        <a href="{{ route('campuses.edit', $campus->id) }}" class="btn btn-sm btn-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('campuses.destroy', $campus->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من حذف الحرم؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($campuses->isEmpty())
                                <tr>
                                    <td colspan="3">لا توجد بيانات</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
