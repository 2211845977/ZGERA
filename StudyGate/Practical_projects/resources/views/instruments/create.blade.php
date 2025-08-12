@extends('layouts.app')

@section('title', 'إضافة أداة / جهاز')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة أداة / جهاز جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('instruments.index') }}">الأجهزة</a></li>
                        <li class="breadcrumb-item active">إضافة</li>
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
                    <h3 class="card-title">نموذج إضافة أداة / جهاز</h3>
                </div>

                <form action="{{ route('instruments.store') }}" method="POST">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-md-6">
                            <label>الاسم</label>
                            <input type="text" name="name" class="form-control" placeholder="اسم الأداة" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>الغرض</label>
                            <input type="text" name="purpose" class="form-control" placeholder="الغرض من الأداة">
                        </div>


                        <div class="form-group col-md-12">
                            <label>الوصف</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="وصف الأداة"></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label>الرقم التسلسلي</label>
                            <input type="text" name="serial_number" class="form-control" placeholder="SN12345">
                        </div>

                        <div class="form-group col-md-6">
                            <label>الموديل</label>
                            <input type="text" name="model" class="form-control" placeholder="موديل الجهاز">
                        </div>

                        <div class="form-group col-md-6">
                            <label>أنواع التجارب المدعومة</label>
                            <input type="text" name="experiment_types" class="form-control" placeholder="مثال: تحليل كيميائي">
                        </div>

                        <div class="form-group col-md-6">
                            <label>نوع التحليل الممكن</label>
                            <input type="text" name="analysis_types" class="form-control" placeholder="مثال: تحليل حراري">
                        </div>

                        <div class="form-group col-md-6">
                            <label>المواد المطلوبة</label>
                            <input type="text" name="required_materials" class="form-control" placeholder="مثال: ماء مقطر، عينات">
                        </div>

                        <div class="form-group col-md-6">
                            <label>الشخص المسؤول</label>
                            <input type="text" name="responsible_person" class="form-control" placeholder="اسم الفني أو المدير">
                        </div>

                        <div class="form-group col-md-6">
                            <label>الحالة</label>
                            <select name="status" class="form-control">
                                <option value="active">نشط</option>
                                <option value="maintenance">تحت الصيانة</option>
                                <option value="out_of_order">خارج الخدمة</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> حفظ</button>
                        <a href="{{ route('instruments.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
