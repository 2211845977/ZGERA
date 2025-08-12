@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>الملف الشخصي</h1>
                @if($currentSemester)
                    <p class="text-muted">{{ $currentSemester->name }}</p>
                @endif
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">الملف الشخصي</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- معلومات شخصية -->
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-2"></i>المعلومات الشخصية
                        </h3>
                    </div>
                    <div class="card-body text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('adminlte/dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                        <h3 class="profile-username text-center">د. {{ $teacher->name }}</h3>
                        <p class="text-muted text-center">{{ $teacher->role == 'teacher' ? 'عضو هيئة تدريس' : $teacher->role }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>الرقم الوظيفي</b> <a class="float-right">{{ $teacher->id }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>البريد الإلكتروني</b> <a class="float-right">{{ $teacher->email }}</a>
                            </li>
                            @if($teacher->phone_number)
                            <li class="list-group-item">
                                <b>رقم الهاتف</b> <a class="float-right">{{ $teacher->phone_number }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- تفاصيل البيانات -->
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit mr-2"></i>تفاصيل البيانات
                        </h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الاسم الكامل</label>
                                        <input type="text" class="form-control" value="{{ $teacher->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>البريد الإلكتروني</label>
                                        <input type="email" class="form-control" value="{{ $teacher->email }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>رقم الهاتف</label>
                                        <input type="text" class="form-control" value="{{ $teacher->phone_number ?? 'غير محدد' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الجنس</label>
                                        <input type="text" class="form-control" value="{{ $teacher->gender == 'male' ? 'ذكر' : ($teacher->gender == 'female' ? 'أنثى' : 'غير محدد') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تاريخ الميلاد</label>
                                        <input type="text" class="form-control" value="{{ $teacher->birthdate ? $teacher->birthdate->format('Y-m-d') : 'غير محدد' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>تاريخ التسجيل</label>
                                        <input type="text" class="form-control" value="{{ $teacher->created_at->format('Y-m-d') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            @if($teacher->address)
                            <div class="form-group">
                                <label>العنوان</label>
                                <textarea class="form-control" rows="3" readonly>{{ $teacher->address }}</textarea>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- الإحصائيات للفصل الحالي -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-2"></i>
                            إحصائيات {{ $currentSemester ? $currentSemester->name : 'لا يوجد فصل دراسي نشط' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($currentSemester)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-book"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">المواد المكلف بها</span>
                                            <span class="info-box-number">{{ $subjectCount }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-users"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">إجمالي الطلبة</span>
                                            <span class="info-box-number">{{ $totalStudents }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-chalkboard-teacher"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">المحاضرات</span>
                                            <span class="info-box-number">{{ $lectureCount }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">الوحدات</span>
                                            <span class="info-box-number">{{ $totalUnits }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h4>لا يوجد فصل دراسي نشط حالياً</h4>
                                <p>يرجى التواصل مع الإدارة لتفعيل الفصل الدراسي</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
