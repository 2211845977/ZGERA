@extends('layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إضافة مستخدم جديد</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left fa-sm"></i> العودة للقائمة
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">الاسم الكامل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">كلمة المرور <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">الدور <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="">اختر الدور</option>
                                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>طالب</option>
                                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>مدرس</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">رقم الهاتف</label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                           id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                                    @error('phone_number')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">الجنس</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">اختر الجنس</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="birthdate">تاريخ الميلاد</label>
                                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror" 
                                           id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                                    @error('birthdate')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">العنوان</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save fa-sm"></i> حفظ المستخدم
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times fa-sm"></i> إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Password strength indicator
        $('#password').on('input', function() {
            var password = $(this).val();
            var strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            var strengthText = '';
            var strengthClass = '';
            
            switch(strength) {
                case 0:
                case 1:
                    strengthText = 'ضعيف جداً';
                    strengthClass = 'text-danger';
                    break;
                case 2:
                    strengthText = 'ضعيف';
                    strengthClass = 'text-warning';
                    break;
                case 3:
                    strengthText = 'متوسط';
                    strengthClass = 'text-info';
                    break;
                case 4:
                    strengthText = 'قوي';
                    strengthClass = 'text-success';
                    break;
                case 5:
                    strengthText = 'قوي جداً';
                    strengthClass = 'text-success';
                    break;
            }
            
            if (password.length > 0) {
                if (!$('#password-strength').length) {
                    $(this).after('<small id="password-strength" class="form-text ' + strengthClass + '">' + strengthText + '</small>');
                } else {
                    $('#password-strength').text(strengthText).removeClass().addClass('form-text ' + strengthClass);
                }
            } else {
                $('#password-strength').remove();
            }
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/users-management.css') }}">
@endpush 