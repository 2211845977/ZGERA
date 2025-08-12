@extends('layouts.app')

@section('title', 'Add Campus')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة حرم جامعي</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('campuses.index') }}">الحُرُم الجامعية</a></li>
                        <li class="breadcrumb-item active">إضافة</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">إضافة حرم جامعي جديد</h3>
                </div>
                <form action="{{ route('campuses.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">اسم الحرم</label>
                            <input type="text" name="name" class="form-control" placeholder="أدخل اسم الحرم" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-success"><i class="fas fa-save"></i> حفظ</button>
                        <a href="{{ route('campuses.index') }}" class="btn btn-secondary">عودة</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
