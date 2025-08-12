@extends('layouts.app')

@section('title', 'المواد المكلف بها')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">المواد المكلف بها</h1>
                    @if(isset($currentSemester))
                        <p class="text-muted">{{ $currentSemester->name }}</p>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">المواد المكلف بها</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if(!isset($currentSemester))
                <!-- رسالة عدم وجود فصل دراسي نشط -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>تنبيه
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ $message ?? 'لا يوجد فصل دراسي نشط حالياً' }}</h4>
                        <p class="text-muted">يرجى التواصل مع الإدارة لتفعيل الفصل الدراسي</p>
                    </div>
                </div>
            @elseif($subjectOffers->isEmpty())
                <!-- رسالة عدم وجود مواد -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-2"></i>معلومات
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <h4>لا توجد مواد مكلف بها في {{ $currentSemester->name }}</h4>
                        <p class="text-muted">يرجى التواصل مع الإدارة للحصول على المواد</p>
                    </div>
                </div>
            @else
                <!-- جدول المواد -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-book mr-2"></i>
                            المواد المكلف بها - {{ $currentSemester->name }}
                        </h3>
                        <div class="card-tools">
                            <span class="badge badge-light">{{ $subjectOffers->count() }} مادة</span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-bordered table-hover text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 8%">#</th>
                                    <th style="width: 35%">اسم المادة</th>
                                    <th style="width: 15%">رمز المادة</th>
                                    <th style="width: 12%">الوحدات</th>
                                    <th style="width: 15%">عدد الطلبة</th>
                                    <th style="width: 15%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($subjectOffers as $offer)
                                    <tr>
                                        <td class="font-weight-bold">{{ $loop->iteration }}</td>
                                        <td class="text-left">
                                            <div class="font-weight-bold text-primary">{{ $offer->subject->name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $offer->subject->code ?? $offer->subject->id }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-success">{{ $offer->subject->units ?? 0 }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $studentCount = $offer->enrollments->count();
                                                $maxStudents = 40; // الحد الأقصى للطلبة
                                                $percentage = $maxStudents > 0 ? ($studentCount / $maxStudents) * 100 : 0;
                                                $progressColor = $percentage > 80 ? 'danger' : ($percentage > 60 ? 'warning' : 'success');
                                            @endphp
                                            <div class="progress progress-xs mb-1">
                                                <div class="progress-bar bg-{{ $progressColor }}" style="width: {{ min($percentage, 100) }}%"></div>
                                            </div>
                                            <small class="text-muted">{{ $studentCount }}/{{ $maxStudents }} طالب</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('teacher.subject.students', $offer->id) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-users"></i> عرض الطلبة
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- ملخص الإحصائيات -->
                    <div class="card-footer">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="description-block">
                                    <h5 class="description-header text-info">{{ $subjectOffers->count() }}</h5>
                                    <span class="description-text">إجمالي المواد</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="description-block">
                                    <h5 class="description-header text-success">{{ $subjectOffers->sum(fn($offer) => $offer->enrollments->count()) }}</h5>
                                    <span class="description-text">إجمالي الطلبة</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="description-block">
                                    <h5 class="description-header text-warning">{{ $subjectOffers->sum(fn($offer) => $offer->subject->units ?? 0) }}</h5>
                                    <span class="description-text">إجمالي الوحدات</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="description-block">
                                    <h5 class="description-header text-danger">{{ round($subjectOffers->avg(fn($offer) => $offer->enrollments->count()), 1) }}</h5>
                                    <span class="description-text">متوسط الطلبة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
.description-block {
    padding: 10px 0;
}

.description-header {
    margin: 0;
    font-weight: 600;
    font-size: 1.5rem;
}

.description-text {
    text-transform: uppercase;
    font-weight: 600;
    font-size: 0.75rem;
    color: #6c757d;
}

.progress-xs {
    height: 4px;
}

.table th, .table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.8rem;
}
</style>
@endpush