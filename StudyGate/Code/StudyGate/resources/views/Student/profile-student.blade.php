@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')

<div class="content-wrapper">
  <!-- عنوان الصفحة -->
  <section class="content-header">
    <div class="container-fluid text-center">
      <h2 class="mb-3">
        <i class="fas fa-user-circle"></i> الملف الشخصي
      </h2>
    </div>
  </section>

  <!-- المحتوى الرئيسي -->
  <section class="content">
    <div class="container-fluid">
      <!-- رسائل النجاح -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="fas fa-check"></i> {{ session('success') }}
        </div>
      @endif
      
      <div class="row justify-content-center">

        <!-- الكرت الرئيسي -->
        <div class="col-md-8">
          <div class="card card-info shadow-sm">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user"></i> بيانات الطالب
              </h3>
            </div>
            <div class="card-body box-profile">

              <!-- صورة واسم -->
              <div class="text-center mb-4">
                <div class="position-relative d-inline-block">
                  <img class="profile-user-img img-fluid img-circle elevation-2"
                       src="https://adminlte.io/themes/v3/dist/img/user4-128x128.jpg"
                       alt="صورة الطالب"
                       style="width: 120px; height: 120px; object-fit: cover;">
                 
                </div>
                <h3 class="profile-username mt-3">{{ $user->name }}</h3>
                <p class="text-muted mb-2">
                  <i class="fas fa-graduation-cap"></i> طالب
                </p>
                
              </div>

              <!-- بيانات الطالب -->
              <div class="row">
                <div class="col-md-6">
                  <div class="card card-outline card-primary">
                    <div class="card-header">
                      <h4 class="card-title">
                        <i class="fas fa-id-card"></i> المعلومات الأساسية
                      </h4>
                    </div>
                    <div class="card-body p-0">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-id-card-alt text-primary"></i> الرقم الأكاديمي</span>
                          <span class="badge badge-primary badge-pill font-weight-bold">{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-user text-primary"></i> الدور</span>
                          <span class="badge badge-info badge-pill">{{ $user->role == 'student' ? 'طالب' : $user->role }}</span>
                        </li>
                        @if($user->gender)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-venus-mars text-primary"></i> الجنس</span>
                          <span class="badge badge-secondary badge-pill">{{ $user->gender == 'male' ? 'ذكر' : 'أنثى' }}</span>
                        </li>
                        @endif
                        @if($user->birthdate)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-birthday-cake text-primary"></i> تاريخ الميلاد</span>
                          <span class="badge badge-warning badge-pill">{{ $user->birthdate->format('Y-m-d') }}</span>
                        </li>
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="card card-outline card-success">
                    <div class="card-header">
                      <h4 class="card-title">
                        <i class="fas fa-address-book"></i> معلومات الاتصال
                      </h4>
                    </div>
                    <div class="card-body p-0">
                      <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-envelope text-success"></i> البريد الإلكتروني</span>
                          <span class="text-success">{{ $user->email }}</span>
                        </li>
                        @if($user->phone_number)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-phone text-success"></i> الهاتف</span>
                          <span class="text-success">{{ $user->phone_number }}</span>
                        </li>
                        @endif
                        @if($user->address)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-map-marker-alt text-success"></i> العنوان</span>
                          <span class="text-success">{{ $user->address }}</span>
                        </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          <span><i class="fas fa-calendar-alt text-success"></i> تاريخ التسجيل</span>
                          <span class="badge badge-success badge-pill">{{ $user->created_at->format('Y-m-d') }}</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <!-- إحصائيات الطالب -->
              <div class="row mt-4">
                <div class="col-md-4">
                  <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-book"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">المواد المسجلة</span>
                      <span class="info-box-number">{{ $enrollmentsCount ?? 0 }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">الوحدات المنجزة</span>
                      <span class="info-box-number">{{ $totalUnits ?? 0 }}</span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-star"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">المعدل العام</span>
                      <span class="info-box-number">{{ $averageGrade ?? 'غير متوفر' }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- أزرار الإجراءات -->
              <div class="mt-4 text-center">
                <a href="{{ route('student.profile.edit') }}" class="btn btn-info btn-lg">
                  <i class="fas fa-edit"></i> تعديل البيانات
                </a>
                <a href="{{ route('student.sem-details') }}" class="btn btn-primary btn-lg">
                  <i class="fas fa-home"></i> العودة للرئيسية
                </a>
                <a href="{{ route('student.current-sem') }}" class="btn btn-success btn-lg">
                  <i class="fas fa-book"></i> المواد الحالية
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>
@endsection