@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إدارة المباني</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">المباني</li>
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
                    <h3 class="card-title">قائمة المباني</h3>
                    <a href="{{ route('buildings.create') }}" class="btn btn-primary ml-auto">
                        <i class="fas fa-plus"></i> إضافة مبنى
                    </a>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>اسم المبنى</th>
                                <th>الحرم الجامعي</th>  <!-- إضافة عمود الحرم -->
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buildings as $index => $building)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $building->name }}</td>
                                    <td>{{ $building->campus ? $building->campus->name : 'غير محدد' }}</td> <!-- عرض اسم الحرم -->
                                    <td>
                                        <a href="{{ route('buildings.edit', $building->id) }}" class="btn btn-sm btn-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من حذف المبنى؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($buildings->isEmpty())
                                <tr>
                                    <td colspan="4">لا توجد بيانات</td>
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
