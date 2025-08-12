@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إضافة مستخدم جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">المستخدمون</a></li>
                        <li class="breadcrumb-item active">إضافة مستخدم</li>
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
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="ادخل الاسم" required>
                        </div>
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="ادخل البريد الإلكتروني" required>
                        </div>
                        <div class="form-group">
                            <label for="role">الدور</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">اختر الدور</option>
                                <option value="admin">مدير</option>
                                <option value="staff">موظف</option>
                                <option value="student">طالب</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">كلمة المرور</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="ادخل كلمة المرور" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">تأكيد كلمة المرور</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="اعد كتابة كلمة المرور" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection