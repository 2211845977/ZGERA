@extends('layouts.app')

@section('title', 'إدارة الحجوزات')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>إدارة الحجوزات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الحجوزات</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Card -->
            <div class="card card-primary card-outline">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">قائمة الحجوزات</h3>
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary ml-auto">
                        <i class="fas fa-plus"></i> إضافة حجز جديد
                    </a>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>المستخدم</th>
                                <th>الأداة</th>
                                <th>تاريخ الحجز</th>
                                <th>وقت البداية</th>
                                <th>وقت النهاية</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->user ? $booking->user->name : '-' }}</td>
                                    <td>{{ $booking->instrument ? $booking->instrument->name : '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                                    <td>
                                        @if ($booking->status == 'pending')
                                            <span class="badge badge-warning">معلق</span>
                                        @elseif ($booking->status == 'confirmed')
                                            <span class="badge badge-success">مقبول</span>
                                        @else
                                            <span class="badge badge-danger">ملغي</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-info" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
                                    <td colspan="8">لا توجد حجوزات حالياً.</td>
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
