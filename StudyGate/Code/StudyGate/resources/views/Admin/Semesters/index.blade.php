@extends('layouts.app')
@section('title', 'Semesters')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Semesters</h3>
            <a href="{{ route('semesters.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Start New Semester
            </a>
        </div>

        <div class="row">
            @foreach($semesters as $semester)
            <div class="col-md-4">
                <div class="card @if($semester->is_active) card-success @else card-secondary @endif">
                    <div class="card-header">
                        <h5 class="card-title">{{ $semester->name }} Semester</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Start Date:</strong> {{ $semester->start_date }}</p>
                        <p><strong>End Date:</strong> {{ $semester->end_date }}</p>
                        <p><strong>Status:</strong> {{ $semester->is_active ? 'Active' : 'Inactive' }}</p>
                        <p><strong>Enrollment:</strong> {{ $semester->enrollment_open ? 'Open' : 'Closed' }}</p>

                        @if ($semester->is_active)
                            <form action="{{ route('semesters.toggleEnrollment', $semester->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $semester->enrollment_open ? 'btn-danger' : 'btn-success' }}">
                                    {{ $semester->enrollment_open ? 'Close Enrollment' : 'Open Enrollment' }}
                                </button>

                                <a href="{{ route('assignments.index', $semester->id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                        Show Subject Assigments
                                </a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
