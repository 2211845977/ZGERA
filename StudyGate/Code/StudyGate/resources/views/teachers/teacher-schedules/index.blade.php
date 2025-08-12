@extends('layouts.app')

@section('title', 'الجدول الدراسي')

@section('content')
<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>الجدول الدراسي الأسبوعي</h1>
                @if($currentSemester)
                    <p class="text-muted">{{ $currentSemester->name }}</p>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">الجدول الدراسي</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        
        @if(!$hasSubjects)
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle mr-2"></i>تنبيه
                    </h3>
                </div>
                <div class="card-body text-center">
                    <h4>{{ $message ?? 'لا توجد مواد مكلف بها' }}</h4>
                    <p class="text-muted">يرجى التواصل مع الإدارة للحصول على المواد</p>
                </div>
            </div>
        @else
            

            <!-- الجدول الدراسي -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        الجدول الدراسي الأسبوعي - {{ $currentSemester->name }}
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center schedule-table">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th style="width: 12%">اليوم</th>
                                    <th style="width: 17.6%">8:00 - 10:00</th>
                                    <th style="width: 17.6%">10:00 - 12:00</th>
                                    <th style="width: 17.6%">12:00 - 2:00</th>
                                    <th style="width: 17.6%">2:00 - 4:00</th>
                                    <th style="width: 17.6%">4:00 - 6:00</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $dayKey => $dayData)
                                    <tr>
                                        <td class="font-weight-bold bg-light">{{ $dayData['day_name'] }}</td>
                                        @foreach($dayData['sessions'] as $sessionKey => $sessionData)
                                            <td class="{{ !$sessionData['not_scheduled'] ? 'lecture-cell' : '' }}">
                                                @if(!$sessionData['not_scheduled'])
                                                    <div class="d-flex flex-column">
                                                        <span class="font-weight-bold text-sm">{{ $sessionData['subject'] }}</span>
                                                        @if($sessionData['subject_code'])
                                                            <span class="text-xs text-muted">{{ $sessionData['subject_code'] }}</span>
                                                        @endif
                                                        <span class="text-xs {{ $sessionData['room'] == 'لم يحدد بعد' ? 'text-warning' : 'text-info' }}">
                                                            <i class="fas fa-map-marker-alt"></i> {{ $sessionData['room'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <span class="text-muted text-xs">فترة فراغ</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.schedule-table .lecture-cell {
    background-color: #e3f2fd;
    border: 2px solid #2196f3;
    min-height: 80px;
}

.schedule-table .lab-cell {
    background-color: #e8f5e8;
    border: 2px solid #4caf50;
}

.schedule-table .seminar-cell {
    background-color: #fff3e0;
    border: 2px solid #ff9800;
}

.schedule-table td {
    vertical-align: middle;
    min-height: 60px;
    padding: 8px;
}

.schedule-table .text-xs {
    font-size: 0.75rem;
}

.schedule-table .text-sm {
    font-size: 0.85rem;
}

.info-box {
    transition: transform 0.2s ease;
}

.info-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endpush
