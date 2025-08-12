@extends('layouts.app')

@section('title', 'جدول المحاضرات')

@section('content')

<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col text-center">
          <h2>
            <i class="fas fa-calendar-alt ml-1"></i>
            جدول المحاضرات الأسبوعي
            @if($currentSemester)
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
      
      @if(!$currentSemester)
        <!-- رسالة عدم وجود فصل نشط -->
        <div class="card card-warning card-outline">
          <div class="card-body text-center">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h4>{{ $message }}</h4>
            <p class="text-muted">يرجى التسجيل في فصل دراسي لعرض جدول المحاضرات</p>
            <a href="{{ route('student.sem-details') }}" class="btn btn-primary">
              <i class="fas fa-arrow-right mr-2"></i>الذهاب للصفحة الرئيسية
            </a>
          </div>
        </div>
      @elseif(!$hasEnrollments)
        <!-- رسالة عدم وجود مواد مسجلة -->
        <div class="card card-info card-outline">
          <div class="card-body text-center">
            <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
            <h4>لا توجد مواد مسجلة</h4>
            <p class="text-muted">{{ $message }}</p>
            <a href="{{ route('student.add-course') }}" class="btn btn-primary">
              <i class="fas fa-plus ml-1"></i>
              تسجيل مواد جديدة
            </a>
          </div>
        </div>
      @else
        <!-- جدول المحاضرات -->
        <div class="card card-primary card-outline">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover text-center" id="scheduleTable">
                <thead class="bg-light">
                  <tr>
                    <th>14:00 - 15:30</th>
                    <th>12:30 - 14:00</th>
                    <th>11:00 - 12:30</th>
                    <th>09:30 - 11:00</th>
                    <th>08:00 - 09:30</th>
                    <th>اليوم</th>
                  </tr>
                </thead>
                <tbody>
                  @php $dayCounter = 1; @endphp
                  @foreach($schedules as $dayKey => $dayData)
                    <tr>
                      <td>
                        @if(!empty($dayData['sessions']['session5']['subject']))
                          <div class="subject-info">
                            <strong>{{ $dayData['sessions']['session5']['subject_code'] }}</strong><br>
                            <small>{{ $dayData['sessions']['session5']['subject'] }}</small>
                            @if(!empty($dayData['sessions']['session5']['room']))
                              <br><small class="text-muted">قاعة {{ $dayData['sessions']['session5']['room'] }}</small>
                            @endif
                          </div>
                        @endif
                      </td>
                      <td>
                        @if(!empty($dayData['sessions']['session4']['subject']))
                          <div class="subject-info">
                            <strong>{{ $dayData['sessions']['session4']['subject_code'] }}</strong><br>
                            <small>{{ $dayData['sessions']['session4']['subject'] }}</small>
                            @if(!empty($dayData['sessions']['session4']['room']))
                              <br><small class="text-muted">قاعة {{ $dayData['sessions']['session4']['room'] }}</small>
                            @endif
                          </div>
                        @endif
                      </td>
                      <td>
                        @if(!empty($dayData['sessions']['session3']['subject']))
                          <div class="subject-info">
                            <strong>{{ $dayData['sessions']['session3']['subject_code'] }}</strong><br>
                            <small>{{ $dayData['sessions']['session3']['subject'] }}</small>
                            @if(!empty($dayData['sessions']['session3']['room']))
                              <br><small class="text-muted">قاعة {{ $dayData['sessions']['session3']['room'] }}</small>
                            @endif
                          </div>
                        @endif
                      </td>
                      <td>
                        @if(!empty($dayData['sessions']['session2']['subject']))
                          <div class="subject-info">
                            <strong>{{ $dayData['sessions']['session2']['subject_code'] }}</strong><br>
                            <small>{{ $dayData['sessions']['session2']['subject'] }}</small>
                            @if(!empty($dayData['sessions']['session2']['room']))
                              <br><small class="text-muted">قاعة {{ $dayData['sessions']['session2']['room'] }}</small>
                            @endif
                          </div>
                        @endif
                      </td>
                      <td>
                        @if(!empty($dayData['sessions']['session1']['subject']))
                          <div class="subject-info">
                            <strong>{{ $dayData['sessions']['session1']['subject_code'] }}</strong><br>
                            <small>{{ $dayData['sessions']['session1']['subject'] }}</small>
                            @if(!empty($dayData['sessions']['session1']['room']))
                              <br><small class="text-muted">قاعة {{ $dayData['sessions']['session1']['room'] }}</small>
                            @endif
                          </div>
                        @endif
                      </td>
                      <td><strong>({{ $dayCounter }})</strong> {{ $dayData['day_name'] }}</td>
                    </tr>
                    @php $dayCounter++; @endphp
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          
          <!-- تذييل البطاقة -->
          <div class="card-footer text-muted">
            <small>آخر تحديث: {{ date('Y-m-d H:i') }}</small>
          </div>
        </div>
      @endif
    </div>
  </section>
</div>

<style>
.subject-info {
  padding: 5px;
  border-radius: 4px;
  background-color: #f8f9fa;
  border-left: 3px solid #007bff;
}

.subject-info strong {
  color: #007bff;
  font-size: 0.9em;
}

.subject-info small {
  color: #6c757d;
  font-size: 0.8em;
}

.table td {
  vertical-align: middle;
  min-height: 80px;
}

.table th {
  background-color: #e9ecef !important;
  font-weight: bold;
}
</style>

@endsection