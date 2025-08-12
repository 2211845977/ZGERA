@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">تعديل بيانات المدرس</li>
                </ol>
            </nav>
            
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">بيانات المدرس</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">اسم الدكتور</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $teacher->name) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="id_number" class="form-label">الرقم التعريفي</label>
                                    <input type="text" class="form-control" id="id_number" name="id_number" 
                                           value="{{ old('id_number', $teacher->id) }}" required>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $teacher->email) }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone_number" class="form-label">رقم الهاتف</label>
                                    <input type="tel" class="form-control" id="phone_number" name="phone_number" 
                                           value="{{ old('phone_number', $teacher->phone_number) ?? 'غير محدد' }}">
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="address" class="form-label">عنوان السكن</label>
                                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $teacher->address) ?? 'غير محدد' }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning">حفظ التعديلات</button>
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection