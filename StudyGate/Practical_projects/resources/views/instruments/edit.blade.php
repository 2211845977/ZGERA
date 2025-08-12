@extends('layouts.app')

@section('title', 'تعديل الأداة / الجهاز')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تعديل الأداة / الجهاز</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('instruments.index') }}">الأجهزة</a></li>
                        <li class="breadcrumb-item active">تعديل</li>
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

            <!-- Form Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">نموذج تعديل بيانات الجهاز</h3>
                </div>

                <form action="{{ route('instruments.update', $instrument->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label>اسم الأداة</label>
                            <input type="text" name="name" class="form-control" value="{{ $instrument->name }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>الغرض</label>
                            <input type="text" name="purpose" class="form-control" value="{{ $instrument->purpose }}">
                        </div>

                        <div class="form-group col-md-12">
                            <label>الوصف</label>
                            <textarea name="description" class="form-control" rows="2">{{ $instrument->description }}</textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label>الرقم التسلسلي</label>
                            <input type="text" name="serial_number" class="form-control" value="{{ $instrument->serial_number }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>الموديل</label>
                            <input type="text" name="model" class="form-control" value="{{ $instrument->model }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>أنواع التجارب المدعومة</label>
                            <input type="text" name="experiment_types" class="form-control" value="{{ $instrument->experiment_types }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>نوع التحليل</label>
                            <input type="text" name="analysis_types" class="form-control" value="{{ $instrument->analysis_types }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>المواد المطلوبة</label>
                            <input type="text" name="required_materials" class="form-control" value="{{ $instrument->required_materials }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>الشخص المسؤول</label>
                            <input type="text" name="responsible_person" class="form-control" value="{{ $instrument->responsible_person }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>الحالة التشغيلية</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $instrument->status == 'active' ? 'selected' : '' }}>نشط</option>
                                <option value="maintenance" {{ $instrument->status == 'maintenance' ? 'selected' : '' }}>تحت الصيانة</option>
                                <option value="out_of_order" {{ $instrument->status == 'out_of_order' ? 'selected' : '' }}>خارج الخدمة</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> تحديث</button>
                        <a href="{{ route('instruments.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
