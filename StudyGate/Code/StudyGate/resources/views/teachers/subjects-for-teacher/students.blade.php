@extends('layouts.app')

@section('title', 'قائمة الطلبة')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">قائمة الطلبة</h1>
                    <p class="text-muted">{{ $subjectOffer->subject->name }} - {{ $currentSemester->name }}</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('teacher.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teacher.subjects') }}">المواد المكلف بها</a></li>
                        <li class="breadcrumb-item active">قائمة الطلبة</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- معلومات المادة -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-primary">
                            <i class="fas fa-book"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">معلومات المادة</span>
                            <span class="info-box-number">{{ $subjectOffer->subject->name }}</span>
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ ($students->count() / 40) * 100 }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{ $students->count() }} طالب مسجل | {{ $subjectOffer->subject->units ?? 0 }} وحدة | {{ $currentSemester->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- جدول الطلبة -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i> 
                        قائمة الطلبة المسجلين - {{ $currentSemester->name }}
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-light">{{ $students->count() }} طالب</span>
                    </div>
                </div>

                <div class="card-body">
                    <!-- شريط البحث -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" id="studentSearch" class="form-control"
                                    placeholder="بحث بالاسم أو الرقم الجامعي أو البريد الإلكتروني...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">
                                        <i class="fas fa-search"></i> بحث
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الطلبة -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center" id="studentsTable">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 8%">#</th>
                                    <th style="width: 15%">الرقم الجامعي</th>
                                    <th style="width: 30%">اسم الطالب</th>
                                    <th style="width: 25%">البريد الإلكتروني</th>
                                    <th style="width: 12%">الجنس</th>
                                    <th style="width: 10%">رقم الهاتف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $index => $student)
                                    <tr>
                                        <td class="font-weight-bold">{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ $student->id }}</span>
                                        </td>
                                        <td class="text-left">
                                            <div class="font-weight-bold text-primary">{{ $student->name }}</div>
                                        </td>
                                        <td class="text-sm">{{ $student->email }}</td>
                                        <td>
                                            <span class="badge {{ $student->gender == 'male' ? 'badge-primary' : 'badge-success' }}">
                                                {{ $student->gender == 'male' ? 'ذكر' : ($student->gender == 'female' ? 'أنثى' : 'غير محدد') }}
                                            </span>
                                        </td>
                                        <td class="text-sm">{{ $student->phone_number ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-users-slash fa-2x mb-2"></i>
                                            <p>لا يوجد طلاب مسجلين في هذه المادة للفصل الحالي</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- ملخص الإحصائيات -->
                    @if($students->count() > 0)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> ملخص الإحصائيات:</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>إجمالي الطلبة:</strong> {{ $students->count() }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>الذكور:</strong> {{ $students->where('gender', 'male')->count() }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>الإناث:</strong> {{ $students->where('gender', 'female')->count() }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>مدة المادة:</strong> {{ $subjectOffer->subject->units ?? 0 }} وحدات
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("studentSearch");
    const tableRows = document.querySelectorAll("#studentsTable tbody tr");

    searchInput.addEventListener("keyup", function () {
        const keyword = this.value.toLowerCase();

        tableRows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (row.children.length > 1) { // تجاهل صف "لا يوجد طلاب"
                row.style.display = text.includes(keyword) ? "" : "none";
            }
        });
    });
});


</script>
@endpush

@push('styles')
<style>
.info-box {
    margin-bottom: 1rem;
}

.table th, .table td {
    vertical-align: middle;
}

.progress {
    height: 4px;
}

.badge {
    font-size: 0.8rem;
}

#studentSearch {
    border-radius: 4px 0 0 4px;
}

.input-group-append .btn {
    border-radius: 0 4px 4px 0;
}
</style>
@endpush