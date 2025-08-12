@extends('layouts.app')

@section('content')
<div class="content-wrapper" >
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تعديل المستخدم</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المستخدمون</a></li>
                        <li class="breadcrumb-item active">تعديل مستخدم</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">بيانات المستخدم</h3>
                </div>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="role">الدور</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>موظف</option>
                                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>طالب</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">كلمة المرور الجديدة (اختياري)</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="اتركه فارغاً إذا لا تريد التغيير">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="اعد كتابة كلمة المرور">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection