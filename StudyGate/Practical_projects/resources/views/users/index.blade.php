@extends('layouts.app')

@section('content')
<div class="content-wrapper" >
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>قائمة المستخدمين</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">المستخدمون</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <!-- Card Header -->
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">جدول المستخدمين</h3>
                    <a href="{{ route('users.create') }}" class="btn btn-primary ml-auto">
                        <i class="fas fa-user-plus"></i> إضافة مستخدم جديد
                    </a>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                                <th>أنشئ في</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @switch($user->role)
                                            @case('admin')
                                                <span class="badge bg-danger">مدير</span>
                                                @break
                                            @case('staff')
                                                <span class="badge bg-info">موظف</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">طالب</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">لا يوجد مستخدمون حالياً.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
