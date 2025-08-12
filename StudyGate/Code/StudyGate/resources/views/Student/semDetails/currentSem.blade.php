@extends('layouts.app')

@section('title', 'المواد المسجلة')

@section('content')
<style>
    .info-box {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        padding: 5px 10px;
        font-size: 0.8em;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.375rem;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
</style>
    <div class="content-header" dir="rtl">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <h1 class="m-0">المواد المسجلة - {{ $currentSemester->name }}</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid" dir="rtl">

            <!-- إحصائيات الوحدات -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">الوحدات المسجلة</span>
                            <span class="info-box-number">{{ $totalUnits }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">الحد الأقصى</span>
                            <span class="info-box-number">{{ $maxUnits }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-plus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">الوحدات المتاحة</span>
                            <span class="info-box-number">{{ $availableUnits }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أزرار الأعمال -->
            <div class="card">
                <div class="card-body d-flex justify-content-start flex-wrap">
                    <a href="{{ route('student.course-schedule') }}" class="btn btn-primary me-2 mb-2">
                        <i class="fas fa-calendar-alt ms-2"></i> عرض الجدول الدراسي
                    </a>
                    @if($enrollmentOpen && $availableUnits > 0)
                        <a href="{{ route('student.add-course') }}" class="btn btn-success me-2 mb-2">
                            <i class="fas fa-plus ms-2"></i> تسجيل مواد جديدة
                        </a>
                    @elseif(!$enrollmentOpen)
                        <button type="button" class="btn btn-secondary me-2 mb-2" disabled>
                            <i class="fas fa-times ms-2"></i> التسجيل مغلق
                        </button>
                    @else
                        <button type="button" class="btn btn-secondary me-2 mb-2" disabled>
                            <i class="fas fa-times ms-2"></i> تم الوصول للحد الأقصى
                        </button>
                    @endif
                </div>
            </div>

            <!-- المواد المسجلة -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list ms-2"></i> المواد المسجلة
                    </h3>
                </div>
                <div class="card-body">
                    @if($enrollments->count() > 0)
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>رقم المادة</th>
                                <th>اسم المادة</th>
                                <th>الوحدات</th>
                                <th>المدرس</th>
                                <th>تاريخ التسجيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->subjectOffer->subject->id }}</td>
                                <td>{{ $enrollment->subjectOffer->subject->name }}</td>
                                <td><span class="badge badge-info">{{ $enrollment->subjectOffer->subject->units }} وحدات</span></td>
                                <td>
                                    @if($enrollment->subjectOffer->teacher)
                                        {{ $enrollment->subjectOffer->teacher->name }}
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                                <td>{{ $enrollment->enrolled_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($enrollmentOpen)
                                        <button class="btn btn-sm btn-danger" 
                                                onclick="confirmDropSubject({{ $enrollment->id }}, '{{ $enrollment->subjectOffer->subject->name }}')"
                                                title="إسقاط المادة">
                                            <i class="fas fa-times-circle"></i> إسقاط
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled title="إسقاط المواد مغلق">
                                            <i class="fas fa-times-circle"></i> مغلق
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-4">
                        <p class="text-muted">لا توجد مواد مسجلة في هذا الفصل</p>
                        @if($enrollmentOpen && $availableUnits > 0)
                            <a href="{{ route('student.add-course') }}" class="btn btn-primary">
                                <i class="fas fa-plus ms-2"></i> تسجيل مواد جديدة
                            </a>
                        @elseif(!$enrollmentOpen)
                            <p class="text-muted"><i class="fas fa-times-circle"></i> التسجيل في المواد مغلق حالياً</p>
                        @endif
                    </div>
                    @endif
                </div>
                @if($enrollments->count() > 0)
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <strong>إجمالي الوحدات المسجلة: {{ $totalUnits }} وحدات</strong>
                        <span class="text-muted">من أصل {{ $maxUnits }} وحدات</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>



    <script>
        // إسقاط مادة
        function confirmDropSubject(enrollmentId, subjectName) {
            if (confirm(`هل أنت متأكد من إسقاط مادة "${subjectName}"؟`)) {
                dropSubject(enrollmentId, subjectName);
            }
        }

        // إرسال طلب الإسقاط
        function dropSubject(enrollmentId, subjectName) {
            fetch('{{ route("student.drop-subject") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    enrollment_id: enrollmentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('خطأ: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في الاتصال');
            });
        }
    </script>
@endsection