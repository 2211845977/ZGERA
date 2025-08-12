@extends('layouts.app')
@section('title', 'Assignment')

@section('content')
<section class="content">
  <div class="container-fluid pt-4">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">تخصيص الدكاترة للمواد - الفصل: {{ $semester->name }}</h3>
      </div>
<form method="POST" action="{{ route('assignments.store', $semester->id) }}">
  @csrf

  <div class="form-group">
    <label for="subject">اختر المادة</label>
    <select class="form-control" id="subject" name="subject_id" required>
      <option value="">-- اختر المادة --</option>
      @foreach($subjects as $subject)
        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label for="teacher">اختر الدكتور</label>
    <select class="form-control" id="teacher" name="teacher_id" required>
      <option value="">-- اختر الدكتور --</option>
      @foreach($teachers as $teacher)
        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
      @endforeach
    </select>
  </div>

  <button type="submit" class="btn btn-primary">حفظ التخصيص</button>
</form>
    </div>
  </div>
</section>
@endsection
