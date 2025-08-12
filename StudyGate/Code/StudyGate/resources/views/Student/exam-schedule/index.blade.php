@extends('layouts.app')

@section('title', 'جدول الامتحانات')

@section('content')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col text-center">
                    <h2>
                        <i class="fas fa-calendar-check ml-1"></i>
                        جدول الامتحانات
                        @if(isset($currentSemester))
                            - {{ $currentSemester->name }}
                        @endif
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            @if(isset($message))
                <div class="card card-warning card-outline">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">{{ $message }}</h4>
                        @if(!$currentSemester)
                            <p class="text-muted">يرجى التسجيل في فصل دراسي لعرض جدول الامتحانات</p>
                            <a href="{{ route('student.sem-details') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-right mr-2"></i>الذهاب للصفحة الرئيسية
                            </a>
                        @elseif(!$hasEnrollments)
                            <p class="text-muted">يرجى تسجيل مواد دراسية لعرض جدول الامتحانات</p>
                            <a href="{{ route('student.add-course') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>تسجيل مواد جديدة
                            </a>
                        @endif
                    </div>
                </div>
            @else
                @if(isset($examSchedules) && $examSchedules->count() > 0)
                    <!-- الإحصائيات -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-clipboard-list"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">إجمالي الامتحانات</span>
                                    <span class="info-box-number">{{ $examSchedules->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">امتحانات نصفية</span>
                                    <span class="info-box-number">{{ $examSchedules->where('exam_type', 'Midterm')->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-graduation-cap"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">امتحانات نهائية</span>
                                    <span class="info-box-number">{{ $examSchedules->where('exam_type', 'Final')->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الامتحانات -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">جدول الامتحانات المجدولة</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>رقم المادة</th>
                                            <th>اسم المادة</th>
                                            <th>نوع الامتحان</th>
                                            <th>التاريخ</th>
                                            <th>الجلسة</th>
                                            <th>القاعة</th>
                                            <th>المدرس</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($examSchedules->sortBy('exam_date') as $exam)
                                            <tr>
                                                <td>{{ $exam->subjectOffer->subject->code ?? 'N/A' }}</td>
                                                <td>{{ $exam->subjectOffer->subject->name ?? 'غير محدد' }}</td>
                                                <td>
                                                    <span class="badge {{ $exam->exam_type == 'Midterm' ? 'badge-warning' : 'badge-danger' }}">
                                                        {{ $exam->exam_type == 'Midterm' ? 'امتحان نصفي' : 'امتحان نهائي' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($exam->exam_date)->format('Y-m-d') }}
                                                    <br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($exam->exam_date)->locale('ar')->isoFormat('dddd') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $exam->session ?? 'لم يحدد' }}</span>
                                                </td>
                                                <td>{{ $exam->room ?? 'لم يحدد' }}</td>
                                                <td>
                                                    @if($exam->subjectOffer->teacher)
                                                        {{ $exam->subjectOffer->teacher->name }}
                                                    @else
                                                        <span class="text-muted">غير محدد</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <strong>الامتحانات المجدولة:</strong> {{ $examSchedules->count() }} امتحان
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        تأكد من مراجعة مواعيد وقاعات الامتحانات قبل الموعد المحدد
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card card-primary card-outline">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-calendar-times" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="text-muted mt-3">لا توجد امتحانات مجدولة</p>
                            <small class="text-muted">
                                لم يتم جدولة امتحانات للمواد المسجلة بعد أو لا توجد مواد مسجلة
                            </small>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>
</div>

@endsection