@extends('layouts.app')

@section('title', 'تفاصيل المستخدم')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">تفاصيل المستخدم</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit fa-sm"></i> تعديل
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left fa-sm"></i> العودة للقائمة
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">الاسم الكامل:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>البريد الإلكتروني:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>الدور:</th>
                                    <td>
                                        @switch($user->role)
                                            @case('student')
                                                <span class="badge badge-primary">طالب</span>
                                                @break
                                            @case('teacher')
                                                <span class="badge badge-success">مدرس</span>
                                                @break
                                            @case('admin')
                                                <span class="badge badge-danger">مدير</span>
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>رقم الهاتف:</th>
                                    <td>{{ $user->phone_number ?? 'غير محدد' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">الجنس:</th>
                                    <td>
                                        @if($user->gender)
                                            {{ $user->gender == 'male' ? 'ذكر' : 'أنثى' }}
                                        @else
                                            غير محدد
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>تاريخ الميلاد:</th>
                                    <td>{{ $user->birthdate ? $user->birthdate->format('Y-m-d') : 'غير محدد' }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء:</th>
                                    <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث:</th>
                                    <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($user->address)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>العنوان:</h5>
                            <p class="text-muted">{{ $user->address }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>إحصائيات المستخدم:</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">عضو منذ</span>
                                            <span class="info-box-number">{{ $user->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">آخر تحديث</span>
                                            <span class="info-box-number">{{ $user->updated_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">حالة البريد</span>
                                            <span class="info-box-number">
                                                @if($user->email_verified_at)
                                                    <span class="badge badge-success">مؤكد</span>
                                                @else
                                                    <span class="badge badge-warning">غير مؤكد</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-primary">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">رقم المستخدم</span>
                                            <span class="info-box-number">#{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">الإجراءات السريعة</h5>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit fa-sm"></i> تعديل المستخدم
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash fa-sm"></i> حذف المستخدم
                                        </button>
                                    </form>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-list fa-sm"></i> العودة للقائمة
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users-management.css') }}">
@endpush 