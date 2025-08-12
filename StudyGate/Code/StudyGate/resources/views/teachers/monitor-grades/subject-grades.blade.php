@extends('layouts.app')

@section('title', 'رصد الدرجات')

@section('content')
<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>رصد الدرجات</h1>
                <p class="text-muted">{{ $subjectOffer->subject->name }} - {{ $currentSemester->name }}</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('teacher.monitor-grades') }}">مراقبة الدرجات</a></li>
                    <li class="breadcrumb-item active">{{ $subjectOffer->subject->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- معلومات المادة -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4>{{ $subjectOffer->subject->name }}</h4>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-code"></i> رمز المادة: {{ $subjectOffer->subject->code ?? $subjectOffer->subject->id }} |
                                    <i class="fas fa-clock"></i> {{ $subjectOffer->subject->units ?? 0 }} وحدة |
                                    <i class="fas fa-calendar"></i> {{ $currentSemester->name }}
                                </p>
                            </div>
                            <div class="col-md-4 text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" onclick="saveAllGrades()">
                                        <i class="fas fa-save"></i> حفظ جميع الدرجات
                                    </button>
                                    <a href="{{ route('teacher.monitor-grades') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> العودة
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- الإحصائيات -->
        <div class="row mb-3">
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $stats['total_students'] }}</h3>
                        <p>إجمالي الطلبة</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $stats['graded_students'] }}</h3>
                        <p>تم رصد درجاتهم</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['average_grade'] }}%</h3>
                        <p>متوسط الدرجات</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $stats['total_students'] - $stats['graded_students'] }}</h3>
                        <p>في انتظار الرصد</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الدرجات -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-2"></i>
                    رصد الدرجات - {{ $subjectOffer->subject->name }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="bg-primary">
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%">الرقم الجامعي</th>
                                <th width="20%">اسم الطالب</th>
                                <th width="12%">الاختبار الأول<br><small>(20 درجة)</small></th>
                                <th width="12%">الاختبار الثاني<br><small>(20 درجة)</small></th>
                                <th width="12%">الاختبار النهائي<br><small>(60 درجة)</small></th>
                                <th width="10%">المجموع</th>
                                <th width="10%">التقدير</th>
                                <th width="7%">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $studentData)
                                <tr data-enrollment-id="{{ $studentData['enrollment']->id }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $studentData['student']->id }}</span>
                                    </td>
                                    <td class="text-left">
                                        <strong>{{ $studentData['student']->name }}</strong>
                                    </td>
                                    <td>
                                        <input type="number"
                                               class="form-control form-control-sm grade-input"
                                               name="midterm_1"
                                               value="{{ $studentData['gradeRecord']->midterm_1 ?? '' }}"
                                               min="0" max="20"
                                               data-enrollment="{{ $studentData['enrollment']->id }}"
                                               onchange="calculateTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number"
                                               class="form-control form-control-sm grade-input"
                                               name="midterm_2"
                                               value="{{ $studentData['gradeRecord']->midterm_2 ?? '' }}"
                                               min="0" max="20"
                                               data-enrollment="{{ $studentData['enrollment']->id }}"
                                               onchange="calculateTotal(this)">
                                    </td>
                                    <td>
                                        <input type="number"
                                               class="form-control form-control-sm grade-input"
                                               name="final_exam"
                                               value="{{ $studentData['gradeRecord']->final_exam ?? '' }}"
                                               min="0" max="60"
                                               data-enrollment="{{ $studentData['enrollment']->id }}"
                                               onchange="calculateTotal(this)">
                                    </td>
                                    <td class="font-weight-bold total-grade">
                                        {{ $studentData['totalGrade'] > 0 ? $studentData['totalGrade'] : '-' }}
                                    </td>
                                    <td class="letter-grade">
                                        @if($studentData['grade'])
                                            <span class="badge {{ getGradeBadgeClass($studentData['grade']) }}">
                                                {{ $studentData['grade'] }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success save-grade-btn"
                                                data-enrollment="{{ $studentData['enrollment']->id }}"
                                                onclick="saveGrade({{ $studentData['enrollment']->id }})"
                                                title="حفظ الدرجات">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-users-slash fa-2x mb-2"></i>
                                        <p>لا يوجد طلاب مسجلين في هذه المادة</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// حساب المجموع والتقدير تلقائياً
function calculateTotal(input) {
    const row = input.closest('tr');
    const enrollmentId = input.dataset.enrollment;

    // جلب قيم الدرجات
    const midterm1 = parseFloat(row.querySelector('input[name="midterm_1"]').value) || 0;
    const midterm2 = parseFloat(row.querySelector('input[name="midterm_2"]').value) || 0;
    const finalExam = parseFloat(row.querySelector('input[name="final_exam"]').value) || 0;

    // حساب المجموع
    const total = midterm1 + midterm2 + finalExam;

    // تحديث المجموع
    row.querySelector('.total-grade').textContent = total > 0 ? total : '-';

    // حساب التقدير
    const letterGrade = calculateLetterGrade(total);
    const gradeCell = row.querySelector('.letter-grade');

    if (total > 0) {
        gradeCell.innerHTML = `<span class="badge ${getGradeBadgeClass(letterGrade)}">${letterGrade}</span>`;
    } else {
        gradeCell.innerHTML = '<span class="text-muted">-</span>';
    }
}

function calculateLetterGrade(total) {
    if (total >= 95) return 'A+';
    if (total >= 90) return 'A';
    if (total >= 85) return 'B+';
    if (total >= 80) return 'B';
    if (total >= 75) return 'C+';
    if (total >= 70) return 'C';
    if (total >= 65) return 'D+';
    if (total >= 60) return 'D';
    return 'F';
}

function getGradeBadgeClass(grade) {
    const gradeColors = {
        'A+': 'badge-success',
        'A': 'badge-success',
        'B+': 'badge-primary',
        'B': 'badge-primary',
        'C+': 'badge-info',
        'C': 'badge-info',
        'D+': 'badge-warning',
        'D': 'badge-warning',
        'F': 'badge-danger'
    };
    return gradeColors[grade] || 'badge-secondary';
}

// حفظ درجات طالب واحد
function saveGrade(enrollmentId) {
    const row = document.querySelector(`tr[data-enrollment-id="${enrollmentId}"]`);
    const midterm1 = row.querySelector('input[name="midterm_1"]').value;
    const midterm2 = row.querySelector('input[name="midterm_2"]').value;
    const finalExam = row.querySelector('input[name="final_exam"]').value;

    fetch(`{{ url('teacher/monitor-grades/update') }}/${enrollmentId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            midterm_1: midterm1,
            midterm_2: midterm2,
            final_exam: finalExam
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('تم حفظ الدرجات بنجاح', 'success');
        } else {
            showAlert('حدث خطأ أثناء الحفظ', 'error');
        }
    })
    .catch(error => {
        showAlert('حدث خطأ أثناء الحفظ', 'error');
    });
}
// حفظ جميع الدرجات
function saveAllGrades() {
    const rows = document.querySelectorAll('tbody tr[data-enrollment-id]');
    let savedCount = 0;
    const totalRows = rows.length;

    if (totalRows === 0) {
        showAlert('لا توجد درجات للحفظ', 'warning');
        return;
    }

    rows.forEach(row => {
        const enrollmentId = row.dataset.enrollmentId;
        const midterm1 = row.querySelector('input[name="midterm_1"]').value;
        const midterm2 = row.querySelector('input[name="midterm_2"]').value;
        const finalExam = row.querySelector('input[name="final_exam"]').value;

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('midterm_1', midterm1);
        formData.append('midterm_2', midterm2);
        formData.append('final_exam', finalExam);

        fetch(`{{ url('teacher/monitor-grades/update') }}/${enrollmentId}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            savedCount++;
            if (savedCount === totalRows) {
                showAlert(`تم حفظ درجات ${savedCount} طالب بنجاح`, 'success');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
}

function showAlert(message, type) {
    const alertClass = type === 'success' ? 'alert-success' :
                      type === 'error' ? 'alert-danger' : 'alert-warning';

    const alert = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;

    document.querySelector('.container-fluid').insertAdjacentHTML('afterbegin', alert);

    setTimeout(() => {
        const alertElement = document.querySelector('.alert');
        if (alertElement) alertElement.remove();
    }, 3000);
}
</script>
@endpush

@push('styles')
<style>
.grade-input {
    text-align: center;
}

.total-grade {
    font-size: 1.1em;
    color: #007bff;
}

.table th {
    text-align: center;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.save-grade-btn {
    transition: all 0.3s ease;
}

.save-grade-btn:hover {
    transform: scale(1.1);
}

.small-box {
    border-radius: 0.5rem;
}

.badge {
    font-size: 0.85em;
}
</style>
@endpush

@php
function getGradeBadgeClass($grade) {
    $gradeColors = [
        'A+' => 'badge-success',
        'A' => 'badge-success',
        'B+' => 'badge-primary',
        'B' => 'badge-primary',
        'C+' => 'badge-info',
        'C' => 'badge-info',
        'D+' => 'badge-warning',
        'D' => 'badge-warning',
        'F' => 'badge-danger'
    ];
    return $gradeColors[$grade] ?? 'badge-secondary';
}
@endphp
