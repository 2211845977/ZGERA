@extends('layouts.app')
@section('title', 'Assign Doctor')
@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid pt-4">
    <div class="card card-primary">

      <!-- جدول التخصيصات الحالية -->
    <section class="content">
      <div class="container-fluid">

        <!-- كارت فتح فصل -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">فتح فصل دراسي جديد</h3>
          </div>

          <form action="{{ route('semesters.store') }}" method="POST">
    @csrf

    <div class="card-body">

        <div class="form-group">
            <label for="name">اسم الفصل</label>
            <select class="form-control" id="name" name="name" required>
            <option value="">-- اختر الفصل --</option>
            <option value="ربيع 2024">ربيع 2024</option>
            <option value="خريف 2024">خريف 2024</option>
            <option value="صيف 2024">صيف 2024</option>
        </select>

            </select>
        </div>

        {{-- <div class="form-group">
            <label for="year">السنة الدراسية</label>
            <input type="number" class="form-control" id="year" name="year" placeholder="مثال: 2025" min="2000" max="2100" required>
        </div> --}}

        <div class="form-group">
            <label for="start_date">تاريخ البداية</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>

        </div>

        <div class="form-group">
            <label for="end_date">تاريخ النهاية</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>

    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">فتح الفصل</button>
        <button type="reset" class="btn btn-secondary">إلغاء</button>
    </div>
</form>
        </div>



      </div>
    </section>
    </div>
  </div>
</section>
@endsection
