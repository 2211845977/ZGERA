@extends('layouts.app')

@section('content')

    <section class="content-header text-center">
        <h2>
            👋 مرحبًا د. {{ Auth::user()->name }}
        </h2>
        <p class="text-muted">لوحة المعلومات الخاصة بك - {{ $currentSemester ? $currentSemester->name : 'لا يوجد فصل دراسي نشط' }}</p>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if($currentSemester)
                <!--  كروت المعلومات للفصل الحالي -->
                <div class="row g-3 mb-4">
                    @php
                        $boxes = [
                            ['count' => $subjectCount, 'label' => 'عدد المواد المكلف بها في الفصل الحالي', 'color' => 'info', 'icon' => 'fas fa-book'],
                            ['count' => $totalStudents, 'label' => 'إجمالي الطلبة في مواد الفصل الحالي', 'color' => 'success', 'icon' => 'fas fa-user-graduate'],
                            ['count' => $lectureCount, 'label' => 'عدد المحاضرات في الفصل الحالي', 'color' => 'warning', 'icon' => 'fas fa-chalkboard-teacher'],
                            ['count' => $subjectStats->sum('units'), 'label' => 'إجمالي الوحدات المكلف بها', 'color' => 'danger', 'icon' => 'fas fa-calculator'],
                        ];
                    @endphp

                    @foreach($boxes as $box)
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="small-box bg-{{ $box['color'] }} shadow-sm rounded">
                                <div class="inner">
                                    <h3>{{ $box['count'] }}</h3>
                                    <p>{{ $box['label'] }}</p>
                                </div>
                                <div class="icon">
                                    <i class="{{ $box['icon'] }}"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!--  جدول المواد المكلف بها في الفصل الحالي -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow rounded">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-book-reader me-2"></i> 
                                    المواد المكلف بها - {{ $currentSemester->name }}
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-bordered table-hover text-center mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>المادة</th>
                                            <th>عدد الوحدات</th>
                                            <th>عدد الطلبة</th>
                                            <th>عدد المحاضرات</th>
                                            <th>الإجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subjectOffers as $offer)
                                            <tr>
                                                <td>{{ $offer->subject->name }}</td>
                                                <td>{{ $offer->subject->units ?? 0 }}</td>
                                                <td>
                                                    <span class="badge badge-info">{{ $offer->enrollments->count() }}</span>
                                                </td>
                                                <td>{{ $offer->schedules->count() }}</td>
                                                <td>
                                                    <a href="{{ route('teacher.subject.students', $offer->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-users"></i> عرض الطلبة
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-muted py-4">
                                                    <i class="fas fa-info-circle"></i> لا توجد مواد مكلف بها في الفصل الحالي
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!--  رسالة عدم وجود فصل دراسي نشط -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow rounded">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                <h4>لا يوجد فصل دراسي نشط حالياً</h4>
                                <p class="text-muted">يرجى التواصل مع الإدارة لتفعيل الفصل الدراسي</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
