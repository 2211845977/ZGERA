@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة مبنى جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('buildings.index') }}">المباني</a></li>
                        <li class="breadcrumb-item active">إضافة</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">نموذج إضافة مبنى</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('buildings.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">اسم المبنى</label>
                            <input type="text" name="name" class="form-control" placeholder="أدخل اسم المبنى" required>
                        </div>

                        <div class="form-group">
                            <label for="campus_id">الحرم الجامعي</label>
                            <select name="campus_id" class="form-control" required>
                                <option value="">-- اختر الحرم الجامعي --</option>
                                @foreach ($campuses as $campus)
                                    <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> حفظ
                        </button>
                        <a href="{{ route('buildings.index') }}" class="btn btn-secondary">إلغاء</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
