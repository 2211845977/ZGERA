@extends('layouts.app')

@section('title', 'تعديل البيانات الشخصية')

@section('content')

<div class="content-wrapper">
  <!-- عنوان الصفحة -->
  <section class="content-header">
    <div class="container-fluid text-center">
      <h2 class="mb-3">
        <i class="fas fa-edit"></i> تعديل البيانات الشخصية
      </h2>
    </div>
  </section>

  <!-- المحتوى الرئيسي -->
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-primary shadow-sm">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-user-edit"></i> تحديث المعلومات الشخصية
              </h3>
            </div>
            
            <form action="{{ route('student.profile.update') }}" method="POST" style="direction: rtl;">
              @csrf
              @method('PUT')
              
              <div class="card-body">
                
                <!-- رسائل النجاح والخطأ -->
                @if(session('success'))
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fas fa-check"></i> {{ session('success') }}
                  </div>
                @endif

                @if($errors->any())
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="fas fa-exclamation-triangle"></i> يرجى تصحيح الأخطاء التالية:</h5>
                    <ul>
                      @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif

                <!-- المعلومات الأساسية -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">
                        <i class="fas fa-user text-primary"></i> الاسم الكامل
                      </label>
                      <input type="text" 
                             class="form-control @error('name') is-invalid @enderror" 
                             id="name" 
                             name="name" 
                             value="{{ old('name', $user->name) }}" 
                             required>
                      @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">
                        <i class="fas fa-envelope text-primary"></i> البريد الإلكتروني
                      </label>
                      <input type="email" 
                             class="form-control @error('email') is-invalid @enderror" 
                             id="email" 
                             name="email" 
                             value="{{ old('email', $user->email) }}" 
                             required>
                      @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone_number">
                        <i class="fas fa-phone text-primary"></i> رقم الهاتف
                      </label>
                      <input type="text" 
                             class="form-control @error('phone_number') is-invalid @enderror" 
                             id="phone_number" 
                             name="phone_number" 
                             value="{{ old('phone_number', $user->phone_number) }}">
                      @error('phone_number')
                        <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender">
                        <i class="fas fa-venus-mars text-primary"></i> الجنس
                      </label>
                      <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="">اختر الجنس</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                      </select>
                      @error('gender')
                        <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="birthdate">
                        <i class="fas fa-birthday-cake text-primary"></i> تاريخ الميلاد
                      </label>
                      <input type="date" 
                             class="form-control @error('birthdate') is-invalid @enderror" 
                             id="birthdate" 
                             name="birthdate" 
                             value="{{ old('birthdate', $user->birthdate ? $user->birthdate->format('Y-m-d') : '') }}">
                      @error('birthdate')
                        <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="address">
                        <i class="fas fa-map-marker-alt text-primary"></i> العنوان
                      </label>
                      <textarea class="form-control @error('address') is-invalid @enderror" 
                                id="address" 
                                name="address" 
                                rows="3">{{ old('address', $user->address) }}</textarea>
                      @error('address')
                        <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <!-- تغيير كلمة المرور -->
                <div class="card card-outline card-warning mt-4">
                  <div class="card-header">
                    <h4 class="card-title">
                      <i class="fas fa-key"></i> تغيير كلمة المرور
                    </h4>
                  </div>
                  <div class="card-body">
                    <div class="alert alert-info">
                      <i class="fas fa-info-circle"></i> 
                      <strong>ملاحظة:</strong> اترك حقول كلمة المرور فارغة إذا كنت لا تريد تغييرها
                    </div>
                    
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="current_password">
                            <i class="fas fa-lock text-warning"></i> كلمة المرور الحالية
                          </label>
                          <input type="password" 
                                 class="form-control @error('current_password') is-invalid @enderror" 
                                 id="current_password" 
                                 name="current_password"
                                 placeholder="أدخل كلمة المرور الحالية">
                          @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="new_password">
                            <i class="fas fa-lock text-warning"></i> كلمة المرور الجديدة
                          </label>
                          <input type="password" 
                                 class="form-control @error('new_password') is-invalid @enderror" 
                                 id="new_password" 
                                 name="new_password"
                                 placeholder="أدخل كلمة المرور الجديدة">
                          @error('new_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                          @enderror
                        </div>
                      </div>
                      
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="new_password_confirmation">
                            <i class="fas fa-lock text-warning"></i> تأكيد كلمة المرور
                          </label>
                          <input type="password" 
                                 class="form-control" 
                                 id="new_password_confirmation" 
                                 name="new_password_confirmation"
                                 placeholder="أعد إدخال كلمة المرور الجديدة">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row mt-3">
                      <div class="col-12">
                        <div class="password-strength" id="passwordStrength" style="display: none;">
                          <div class="progress" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                          </div>
                          <small class="text-muted mt-1 d-block">قوة كلمة المرور</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="fas fa-save"></i> حفظ التغييرات
                </button>
                <a href="{{ route('student.profile') }}" class="btn btn-secondary btn-lg">
                  <i class="fas fa-times"></i> إلغاء
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // إظهار قوة كلمة المرور
    $('#new_password').on('input', function() {
        const password = $(this).val();
        const strengthDiv = $('#passwordStrength');
        const progressBar = strengthDiv.find('.progress-bar');
        
        if (password.length > 0) {
            strengthDiv.show();
            
            let strength = 0;
            let color = 'danger';
            
            // فحص طول كلمة المرور
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;
            
            // فحص وجود أحرف كبيرة
            if (/[A-Z]/.test(password)) strength += 25;
            
            // فحص وجود أرقام
            if (/\d/.test(password)) strength += 25;
            
            // فحص وجود رموز خاصة
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 25;
            
            // تحديد اللون
            if (strength >= 75) color = 'success';
            else if (strength >= 50) color = 'warning';
            else if (strength >= 25) color = 'info';
            else color = 'danger';
            
            progressBar.css('width', strength + '%').removeClass().addClass('progress-bar bg-' + color);
        } else {
            strengthDiv.hide();
        }
    });
    
    // تأكيد كلمة المرور
    $('#new_password_confirmation').on('input', function() {
        const password = $('#new_password').val();
        const confirmation = $(this).val();
        
        if (confirmation.length > 0) {
            if (password === confirmation) {
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
        }
    });
    
    // تحسين تجربة الإدخال
    $('input[type="text"], input[type="email"], input[type="tel"]').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });
});
</script>
@endpush 