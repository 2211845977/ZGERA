@extends('layouts.app')
@section('title', 'Assignment')
@section('content')
<section class="content">
  <div class="container-fluid pt-4">

    {{-- Flash Messages --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    @endif

    <div class="card card-primary">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">تخصيص المواد - الفصل: {{ $semester->name }}</h3>
        <a href="{{ route('assignments.create', $semester->id) }}" class="btn btn-outline-light btn-sm">
          <i class="fas fa-plus-circle"></i> تخصيص دكتور لمادة
        </a>
      </div>

      <div class="card-body table-responsive">
      <table class="table table-bordered table-hover text-center">
  <thead class="thead-dark">
    <tr>
      <th>المادة</th>
      <th>الدكتور</th>
      <th>إجراءات</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($offers as $offer)
      <tr>
        <td>{{ $offer->subjectInfo->name ?? 'غير معروف' }}</td>
        <td>{{ $offer->teacher->name ?? 'غير مخصص' }}</td>
        <td>
          {{-- Edit button --}}
          <a href="{{ route('assignments.edit', $offer->id) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> تعديل
          </a>

          {{-- Delete button inside form --}}
          <form action="{{ route('assignments.destroy', $offer->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف هذا التخصيص؟');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">
              <i class="fas fa-trash"></i> حذف
            </button>
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="3">لا توجد تخصيصات حالياً لهذا الفصل.</td>
      </tr>
    @endforelse
  </tbody>
</table>

      </div>

    </div>
  </div>
</section>
@endsection
