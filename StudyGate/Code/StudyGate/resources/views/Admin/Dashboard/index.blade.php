{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!--  كارد ترحيبي -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-primary shadow-sm text-center">
                        <h5><i class="fas fa-tachometer-alt"></i> مرحبًا بك في لوحة التحكم</h5>
                        يمكنك من هنا متابعة الإحصائيات، إدارة الامتحانات، والاطلاع على أحدث الجداول.
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $studentsCount }}</h3>
                            <p>عدد الطلاب</p>

                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <a href="{{ route('admin.student.index') }}" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $subjectsCount }}</h3>
                            <p>عدد المواد</p>

                        </div>
                        <div class="icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <a href="{{ route('admin.subjects.index') }}" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $teachersCount }}</h3>
                            <p>عدد الأساتذة</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <a href="{{ route('admin.teachers.index') }}" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $semestersCount }}</h3>
                            <p>عدد الفصول</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <a href="{{ route('semesters.index') }}" class="small-box-footer">عرض التفاصيل <i class="fas fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- 🟢 الرسم الدائري -->
                <div class="col-md-6">
                    <div class="card card-info shadow">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-2"></i> عدد الطلبة في كل فصل
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" style="height: 250px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- 🔵 رسم الأعمدة -->
                <div class="col-md-6">
                    <div class="card card-info shadow">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-2"></i> عدد المواد في كل فصل
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" style="height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection
@push('scripts')
    <!-- Scripts for charts -->
    <script>
        //  بيانات الطلبة في كل فصل (لـ الشارت الدائري)
        const pieLabels = {!! json_encode(array_keys($studentsPerSemester->toArray())) !!};
        const pieData = {!! json_encode(array_values($studentsPerSemester->toArray())) !!};

        // بيانات عدد المواد في كل فصل (لـ الشارت العمودي)
        const barLabels = {!! json_encode(array_keys($subjectsPerSemester->toArray())) !!};
        const barData = {!! json_encode(array_values($subjectsPerSemester->toArray())) !!};

        //  الرسم الدائري
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'عدد الطلبة في كل فصل',
                    data: pieData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: 'rgba(255, 255, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        //  الرسم العمودي
        const ctxBar = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'عدد المواد في كل فصل',
                    data: barData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endpush