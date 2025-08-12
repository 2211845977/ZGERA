@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="">المستخدمين</a></li>
                    <li class="breadcrumb-item active">تفاصيل</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إدارة المستخدمين</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus fa-sm"></i> إضافة مستخدم جديد
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form action="{{ route('users.search') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="query" class="form-control form-control-sm" placeholder="البحث بالاسم أو البريد الإلكتروني أو رقم الهاتف" value="{{ $query ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="role" class="form-control form-control-sm">
                                        <option value="">جميع الأدوار</option>
                                        <option value="student" {{ ($role ?? '') == 'student' ? 'selected' : '' }}>طالب</option>
                                        <option value="teacher" {{ ($role ?? '') == 'teacher' ? 'selected' : '' }}>مدرس</option>
                                        <option value="admin" {{ ($role ?? '') == 'admin' ? 'selected' : '' }}>مدير</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fas fa-search fa-sm"></i> بحث
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times fa-sm"></i> إلغاء
                                </a>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Users Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الدور</th>
                                    <th>رقم الهاتف</th>
                                    <th>الجنس</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
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
                                    <td>{{ $user->phone_number ?? 'غير محدد' }}</td>
                                    <td>
                                        @if($user->gender)
                                            {{ $user->gender == 'male' ? 'ذكر' : 'أنثى' }}
                                        @else
                                            غير محدد
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('users.show', $user) }}" class="btn btn-info">
                                                <i class="fas fa-eye fa-xs"></i>
                                            </a>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                                <i class="fas fa-edit fa-xs"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash fa-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">لا توجد مستخدمين</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users-management.css') }}">
@endpush 