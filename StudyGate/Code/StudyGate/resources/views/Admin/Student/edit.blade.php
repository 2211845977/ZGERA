@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تعديل بيانات الطالب</li>
                </ol>
            </nav>
            
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">بيانات الطالب</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.student.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">الاسم الكامل</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $student->name) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="registration_number" class="form-label">رقم القيد</label>
                                    <input type="text" class="form-control" id="registration_number" name="registration_number" 
                                           value="{{ old('registration_number', $student->id) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $student->email) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone_number" class="form-label">رقم الهاتف</label>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                           value="{{ old('phone_number', $student->phone_number) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">عنوان السكن</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning">حفظ التعديلات</button>
                            <a href="{{ route('admin.student.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection