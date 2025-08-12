@extends('layouts.app')

@section('title', 'لوحة تحكم الطالب')

@section('content')
    <div class="content-header" dir="rtl">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">لوحة التحكم</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid" dir="rtl">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">بيانات الطالب <i class="fas fa-user ms-2"></i></h3>
                </div>
                <div class="card-body" style="direction: rtl; text-align: right;">
                    <strong>الاسم:</strong> {{ $user->name }} <br>
                    <strong>الرقم الدراسي:</strong> {{ $user->id }} <br>
                    <strong>البريد الإلكتروني:</strong> {{ $user->email }} <br>
                    @if($user->phone_number)
                        <strong>رقم الهاتف:</strong> {{ $user->phone_number }} <br>
                    @endif
                    @if($user->address)
                        <strong>العنوان:</strong> {{ $user->address }} <br>
                    @endif
                </div>
            </div>

            @if($availableSemester && !$isRegisteredForAvailableSemester)
            <div class="callout callout-success shadow-sm" id="availableSemesterCallout" dir="rtl" style="text-align: right;">
                <h5><i class="fas fa-bullhorn me-2"></i>فصل دراسي جديد متاح الآن!</h5>
                <p>تم فتح {{ $availableSemester->name }} للتسجيل. يمكنك الآن تسجيل موادك الدراسية.</p>
                <button class="btn btn-primary btn-lg mt-2" style="color: #ffffff;" onclick="registerForSemester({{ $availableSemester->id }})">
                    <i class="fas fa-plus-circle me-2"></i>اضغط هنا لبدء التسجيل
                </button>
            </div>
            @endif
            
         

            @if($availableSemester && $isRegisteredForAvailableSemester)
            <div class="card card-success card-outline" id="registeredSemesterInfo">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-check-circle me-2"></i> <strong>حالة التسجيل</strong>
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="semester-info">
                            <p><strong>اسم الفصل:</strong> {{ $availableSemester->name }}</p>
                            <p><strong>تاريخ البداية:</strong> {{ $availableSemester->start_date->format('Y-m-d') }}</p>
                            <p><strong>تاريخ النهاية:</strong> {{ $availableSemester->end_date->format('Y-m-d') }}</p>
                            <p><strong>حالة التسجيل:</strong> <span class="badge badge-success">تم التسجيل </span></p>
                        </div>
                        <div>
                            <a href="{{ route('student.current-sem') }}" class="btn btn-info">
                                عرض المواد المسجلة <i class="fas fa-book ms-2"></i>
                            </a>
                            <a href="{{ route('student.add-course') }}" class="btn btn-warning">
                                تسجيل مواد جديدة <i class="fas fa-plus ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-archive me-2"></i> <strong>الفصول السابقة</strong>
                    </h3>
                </div>
                <div class="card-body p-0">
                    @if($previousSemesters->count() > 0)
                    <table class="table table-striped table-hover text-center mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>الفصل الدراسي</th>
                                <th>الوحدات المنجزة</th>
                                <th>المعدل الفصلي</th>
                                <th>تاريخ النهاية</th>
                                <th>إجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($previousSemesters as $semesterData)
                            <tr>
                                <td>
                                    <strong>{{ $semesterData['semester']->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $semesterData['semester']->start_date->format('Y-m-d') }} - {{ $semesterData['semester']->end_date->format('Y-m-d') }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $semesterData['units'] }} وحدات</span>
                                </td>
                                <td>
                                    @if($semesterData['average'] > 0)
                                        <span class="badge badge-success">{{ $semesterData['average'] }}</span>
                                    @else
                                        <span class="badge badge-warning">لم يتم التقييم</span>
                                    @endif
                                </td>
                                <td>{{ $semesterData['semester']->end_date->format('Y-m-d') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="showSemesterSubjects({{ $semesterData['semester']->id }}, '{{ $semesterData['semester']->name }}')">
                                        <i class="fas fa-eye"></i> عرض المواد
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">لا توجد فصول سابقة مسجلة</p>
                        <small class="text-muted">ستظهر هنا الفصول التي سجلت فيها مواد دراسية</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal لعرض مواد الفصل -->
    <div class="modal fade" id="semesterSubjectsModal" tabindex="-1" role="dialog" aria-labelledby="semesterSubjectsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="semesterSubjectsModalLabel">مواد الفصل الدراسي</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="semesterSubjectsContent">
                    <!-- سيتم تحميل المحتوى هنا -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function registerForSemester(semesterId) {
        if (!confirm('هل أنت متأكد من تسجيلك في هذا الفصل الدراسي؟')) {
            return;
        }

        // إظهار loading
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التسجيل...';
        button.disabled = true;

        fetch(`/student/register-semester/${semesterId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // إخفاء التنبيه
                document.getElementById('availableSemesterCallout').style.display = 'none';
                
                // إظهار رسالة نجاح
                alert(data.message);
                
                // إعادة تحميل الصفحة لتحديث البيانات
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء التسجيل');
        })
        .finally(() => {
            // إعادة الزر لحالته الأصلية
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }

    

    function showSemesterSubjects(semesterId, semesterName) {
        if (!semesterId) {
            alert('لا يوجد فصل دراسي نشط');
            return;
        }

        // تحديث عنوان المودال
        document.getElementById('semesterSubjectsModalLabel').textContent = 'مواد ' + semesterName;
        
        // إظهار loading
        document.getElementById('semesterSubjectsContent').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> جاري التحميل...</div>';
        
        // إظهار المودال
        $('#semesterSubjectsModal').modal('show');
        
        // جلب المواد من قاعدة البيانات
        fetch(`/student/semester-subjects/${semesterId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('فشل في جلب البيانات');
                }
                return response.json();
            })
            .then(data => {
                let content = '';
                if (data.subjects && data.subjects.length > 0) {
                    content = `
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th>رمز المادة</th>
                                        <th>اسم المادة</th>
                                        <th>الوحدات</th>
                                        <th>أستاذ المادة</th>
                                        <th>الدرجة</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    data.subjects.forEach(subject => {
                        let gradeDisplay = '';
                        let statusBadge = '';
                        
                        if (subject.grade) {
                            gradeDisplay = `<span class="badge badge-success">${subject.grade}</span>`;
                            statusBadge = '<span class="badge badge-success">مكتمل</span>';
                        } else {
                            gradeDisplay = '<span class="text-muted">لم يتم التقييم</span>';
                            statusBadge = '<span class="badge badge-warning">قيد التقييم</span>';
                        }
                        
                        content += `
                            <tr>
                                <td><strong>${subject.subject_id}</strong></td>
                                <td>${subject.subject_name}</td>
                                <td><span class="badge badge-info">${subject.units} وحدات</span></td>
                                <td>${subject.teacher_name}</td>
                                <td>${gradeDisplay}</td>
                                <td>${statusBadge}</td>
                            </tr>
                        `;
                    });
                    
                    content += `
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>إجمالي المواد:</strong> ${data.subjects.length} مادة
                                </div>
                                <div class="col-md-4">
                                    <strong>إجمالي الوحدات:</strong> ${data.total_units} وحدات
                                </div>
                                <div class="col-md-4">
                                    <strong>المعدل الفصلي:</strong> 
                                    ${data.average ? `<span class="badge badge-info">${data.average}</span>` : '<span class="text-muted">غير متوفر</span>'}
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    content = `
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-book-open" style="font-size: 3rem;"></i>
                            <p class="mt-2">لا توجد مواد مسجلة في هذا الفصل</p>
                            <small>لم يتم تسجيل أي مواد دراسية في هذا الفصل</small>
                        </div>
                    `;
                }
                
                document.getElementById('semesterSubjectsContent').innerHTML = content;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('semesterSubjectsContent').innerHTML = '<div class="text-center text-danger"><p>حدث خطأ أثناء تحميل البيانات</p></div>';
            });
    }
    </script>
@endsection