@extends('layouts.app')
@section('title','assigmnets update')
@section('content')
<section class="content">
  <div class="container-fluid pt-4">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">تعديل التخصيص - {{ $subjectOffer->subjectInfo->name }}</h3>
      </div>

      <form method="POST" action="{{ route('assignments.update', $subjectOffer->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="teacher">اختر الدكتور الجديد</label>
          <select class="form-control" id="teacher" name="teacher_id" required>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}" {{ $teacher->id == $subjectOffer->teacher_id ? 'selected' : '' }}>
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-primary">تحديث التخصيص</button>
      </form>
    </div>
  </div>
</section>
@endsection
