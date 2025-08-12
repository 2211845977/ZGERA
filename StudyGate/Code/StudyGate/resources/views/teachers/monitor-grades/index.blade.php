@extends('layouts.app')

@section('title', 'مراقبة الدرجات')

@section('content')
<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>مراقبة الدرجات</h1>
                @if(isset($currentSemester))
                    <p class="text-muted">{{ $currentSemester->name }}</p>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">مراقبة الدرجات</li>
                </ol>
            </div>
        </div>
    </div>
</section>

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
            <!-- قائمة المواد للاختيار -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book mr-2"></i>
                        اختر المادة لرصد الدرجات - {{ $currentSemester->name }}
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ $subjectOffers->count() }} مادة</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($subjectOffers as $offer)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-left-primary shadow h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    {{ $offer->subject->name }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $offer->enrollments->count() }} طلاب
                                                </div>
                                                <div class="text-sm text-muted">
                                                    {{ $offer->subject->units ?? 0 }} وحدة |
                                                    رمز: {{ $offer->subject->code ?? $offer->subject->id }}
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            @php
                                                $gradedCount = $offer->enrollments->whereNotNull('gradeRecord')->count();
                                                $totalCount = $offer->enrollments->count();
                                                $percentage = $totalCount > 0 ? ($gradedCount / $totalCount) * 100 : 0;
                                            @endphp
                                            <div class="progress mb-2">
                                                <div class="progress-bar bg-success" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <small class="text-muted">تم رصد درجات {{ $gradedCount }} من {{ $totalCount }} طالب</small>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('teacher.monitor-grades.subject', $offer->id) }}"
                                               class="btn btn-primary btn-block">
                                                <i class="fas fa-chart-line mr-1"></i>
                                                رصد الدرجات
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- إحصائيات عامة -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $subjectOffers->count() }}</h3>
                            <p>إجمالي المواد</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $subjectOffers->sum(fn($offer) => $offer->enrollments->count()) }}</h3>
                            <p>إجمالي الطلبة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            @php
                                $totalGraded = $subjectOffers->sum(function($offer) {
                                    return $offer->enrollments->whereNotNull('gradeRecord')->count();
                                });
                            @endphp
                            <h3>{{ $totalGraded }}</h3>
                            <p>الطلبة المرصودة درجاتهم</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            @php
                                $totalPending = $subjectOffers->sum(function($offer) {
                                    return $offer->enrollments->whereNull('gradeRecord')->count();
                                });
                            @endphp
                            <h3>{{ $totalPending }}</h3>
                            <p>في انتظار الرصد</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
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
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.card {
    transition: all 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.progress {
    height: 6px;
}

.small-box {
    border-radius: 0.5rem;
}

.text-xs {
    font-size: 0.75rem;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}
</style>
@endpush

