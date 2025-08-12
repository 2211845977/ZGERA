@extends('layouts.app')

@section('title', 'تسجيل المواد')

@section('content')
<style>
    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .form-check-input:indeterminate {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    
    .btn-group {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .selected-row {
        background-color: rgba(0, 123, 255, 0.1);
    }
    
    .info-box {
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .alert {
        border-radius: 10px;
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
    
    .btn-lg {
        padding: 10px 20px;
        font-size: 1.1em;
        border-radius: 10px;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col text-center">
                    <h2>
                        <i class="fas fa-user-plus ml-1"></i>
                        تسجيل المواد
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
            
            @if(isset($message) && !$hasRegistration)
                <div class="card card-warning card-outline">
                    <div class="card-body text-center">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">{{ $message }}</h4>
                        <p class="text-muted">يرجى التسجيل في فصل دراسي أولاً لتسجيل المواد</p>
                        <a href="{{ route('student.sem-details') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-right mr-2"></i>الذهاب للصفحة الرئيسية
                        </a>
                    </div>
                </div>
                         @else
             <div dir="rtl">
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

            <!-- زر العودة -->
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('student.current-sem') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left ms-2"></i> العودة للفصل الحالي
                    </a>
                </div>
            </div>

            <!-- المواد المتاحة للتسجيل -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list ms-2"></i> المواد المتاحة للتسجيل
                    </h3>
                </div>
                <div class="card-body">
                    @if(isset($enrollmentOpen) && !$enrollmentOpen)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>تنبيه:</strong> التسجيل في المواد مغلق حالياً لهذا الفصل.
                        </div>
                    @elseif($availableUnits <= 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>تنبيه:</strong> لقد وصلت للحد الأقصى من الوحدات المسموح بها ({{ $maxUnits }} وحدات).
                        </div>
                    @endif

                    @if($availableSubjects->count() > 0)
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>اختيار</th>
                                        <th>رقم المادة</th>
                                        <th>اسم المادة</th>
                                        <th>الوحدات</th>
                                        <th>المدرس</th>
                                        <th>المتطلب السابق</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableSubjects as $subjectOffer)
                                    <tr id="row_{{ $subjectOffer->id }}" class="subject-row">
                                        <td>
                                            @if(!isset($enrollmentOpen) || $enrollmentOpen)
                                                <div class="form-check">
                                                    <input class="form-check-input subject-checkbox" 
                                                           type="checkbox" 
                                                           value="{{ $subjectOffer->id }}"
                                                           data-units="{{ $subjectOffer->subject->units }}"
                                                           data-name="{{ $subjectOffer->subject->name }}"
                                                           id="subject_{{ $subjectOffer->id }}"
                                                           onchange="updateSelectedUnits(); toggleRowHighlight(this)"
                                                           data-row-id="row_{{ $subjectOffer->id }}">
                                                    <label class="form-check-label" for="subject_{{ $subjectOffer->id }}"></label>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $subjectOffer->subject->id }}</td>
                                        <td>{{ $subjectOffer->subject->name }}</td>
                                        <td>
                                            <span class="badge badge-primary">
                                                {{ $subjectOffer->subject->units }} وحدات
                                            </span>
                                        </td>
                                        <td>
                                            @if($subjectOffer->teacher)
                                                {{ $subjectOffer->teacher->name }}
                                            @else
                                                <span class="text-muted">غير محدد</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($subjectOffer->subject->prerequisite)
                                                <span class="badge badge-info">{{ $subjectOffer->subject->prerequisite->name }}</span>
                                            @else
                                                <span class="text-muted">لا يوجد</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!isset($enrollmentOpen) || $enrollmentOpen)
                                                <button class="btn btn-sm btn-success" 
                                                        onclick="enrollInSubject({{ $subjectOffer->id }}, '{{ $subjectOffer->subject->name }}', {{ $subjectOffer->subject->units }})">
                                                    <i class="fas fa-plus"></i> تسجيل
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-secondary" disabled>
                                                    <i class="fas fa-times"></i> مغلق
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- أزرار التسجيل المتعدد -->
                        @if(!isset($enrollmentOpen) || $enrollmentOpen)
                        <div class="row mt-3">
                            <div class="col-md-12 text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                            class="btn btn-lg btn-primary" 
                                            id="enrollMultipleBtn" 
                                            onclick="enrollInMultipleSubjects()" 
                                            disabled>
                                        <i class="fas fa-plus-circle"></i> تسجيل في المواد المحددة
                                    </button>
                                    <button type="button" 
                                            class="btn btn-lg btn-secondary" 
                                            onclick="clearSelection()">
                                        <i class="fas fa-times"></i> إلغاء الاختيار
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book-open" style="font-size: 3rem; color: #6c757d;"></i>
                            <p class="text-muted mt-3">لا توجد مواد متاحة للتسجيل</p>
                            <small class="text-muted">
                                جميع المواد إما مسجلة بالفعل أو تحتاج لإنهاء متطلبات سابقة أو تتجاوز الحد الأقصى للوحدات
                            </small>
                        </div>
                    @endif
                </div>
                @if($availableSubjects->count() > 0)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-0 text-center">
                            <strong>المواد المتاحة للتسجيل:</strong> {{ $availableSubjects->count() }} مادة
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12 text-center">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                يمكنك استخدام أزرار التسجيل المتعدد لتسجيل في عدة مواد مرة واحدة
                            </small>
                        </div>
                    </div>
                </div>
                @endif
            </div>
             </div>
        </div>
    </section>
@endif

</div>

<script>
        const maxUnits = {{ $maxUnits }};
        const currentUnits = {{ $totalUnits }};
        const availableUnits = {{ $availableUnits }};
        
        // تسجيل في مادة
        function enrollInSubject(subjectOfferId, subjectName, units) {
            if (confirm(`هل أنت متأكد من تسجيل مادة "${subjectName}" (${units} وحدات)؟`)) {
                fetch('{{ route("student.enroll-subject") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        subject_offer_id: subjectOfferId
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
        }
        
        // تسجيل في عدة مواد
        function enrollInMultipleSubjects() {
            const selectedCheckboxes = document.querySelectorAll('.subject-checkbox:checked');
            
            if (selectedCheckboxes.length === 0) {
                alert('يرجى اختيار مادة واحدة على الأقل');
                return;
            }
            
            // جمع أسماء المواد المحددة
            const selectedSubjects = [];
            const selectedIds = [];
            let totalUnits = 0;
            
            selectedCheckboxes.forEach(checkbox => {
                selectedIds.push(checkbox.value);
                selectedSubjects.push(checkbox.dataset.name);
                totalUnits += parseInt(checkbox.dataset.units);
            });
            
            // تأكيد العملية
            const confirmMessage = `هل أنت متأكد من تسجيل المواد التالية؟\n\n${selectedSubjects.join('\n')}\n\nإجمالي الوحدات: ${totalUnits} وحدة`;
            
            if (confirm(confirmMessage)) {
                // إضافة رسالة تحميل
                const enrollBtn = document.getElementById('enrollMultipleBtn');
                enrollBtn.disabled = true;
                enrollBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التسجيل...';
                
                fetch('{{ route("student.enroll-multiple-subjects") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        subject_offer_ids: selectedIds
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
                })
                .finally(() => {
                    // إعادة تفعيل الزر
                    enrollBtn.disabled = false;
                    // إعادة تحديث نص الزر حسب عدد المواد المحددة
                    updateSelectedUnits();
                });
            }
        }
        
        // تحديث عدد الوحدات المحددة
        function updateSelectedUnits() {
            const selectedCheckboxes = document.querySelectorAll('.subject-checkbox:checked');
            const enrollBtn = document.getElementById('enrollMultipleBtn');
            
            let totalSelectedUnits = 0;
            
            selectedCheckboxes.forEach(checkbox => {
                totalSelectedUnits += parseInt(checkbox.dataset.units);
            });
            
            if (selectedCheckboxes.length > 0) {
                enrollBtn.disabled = false;
                
                // تحديث نص الزر
                const subjectCount = selectedCheckboxes.length;
                enrollBtn.innerHTML = `<i class="fas fa-plus-circle"></i> تسجيل في ${subjectCount} مادة محددة`;
                
                // التحقق من تجاوز الحد الأقصى
                if (totalSelectedUnits > availableUnits) {
                    enrollBtn.disabled = true;
                }
            } else {
                enrollBtn.disabled = true;
                enrollBtn.innerHTML = '<i class="fas fa-plus-circle"></i> تسجيل في المواد المحددة';
            }
        }
        
        // مسح الاختيار
        function clearSelection() {
            const allCheckboxes = document.querySelectorAll('.subject-checkbox');
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // إزالة التمييز من جميع الصفوف
            const allRows = document.querySelectorAll('.subject-row');
            allRows.forEach(row => {
                row.classList.remove('selected-row');
            });
            
            updateSelectedUnits();
        }
        
        // تمييز الصف المحدد
        function toggleRowHighlight(checkbox) {
            const rowId = checkbox.dataset.rowId;
            const row = document.getElementById(rowId);
            
            if (checkbox.checked) {
                row.classList.add('selected-row');
            } else {
                row.classList.remove('selected-row');
            }
        }
    </script>
@endsection