@extends('layouts.app')

@section('title', 'إدارة الطلبة')

@section('content')
<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>إدارة الطلبة</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('teacher.profile') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active">إدارة الطلبة</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>إدارة الطلبة
                </h3>
                <div class="card-tools">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addStudentModal">
                        <i class="fas fa-user-plus"></i> إضافة طالب
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="بحث بالاسم أو الرقم الجامعي...">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i> بحث
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-control">
                            <option>جميع المواد</option>
                            <option>برمجة متقدمة (CS301)</option>
                            <option>ذكاء اصطناعي (CS302)</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-light-blue">
                            <tr>
                                <th>#</th>
                                <th>البيانات</th>
                                <th>المادة</th>
                                <th>الحضور</th>
                                <th>الدرجة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="font-weight-bold">محمد أحمد</div>
                                    <div class="text-sm text-muted">2023101</div>
                                    <div class="text-sm text-muted">m.ahmed@univ.edu</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">CS301</span>
                                    <span class="badge bg-success">CS302</span>
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-success" style="width: 85%"></div>
                                    </div>
                                    <small>85%</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">92/100</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="عرض الملف">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <div class="font-weight-bold">سارة محمد</div>
                                    <div class="text-sm text-muted">2023102</div>
                                    <div class="text-sm text-muted">s.mohamed@univ.edu</div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">CS301</span>
                                </td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-warning" style="width: 65%"></div>
                                    </div>
                                    <small>65%</small>
                                </td>
                                <td>
                                    <span class="badge bg-info">78/100</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" title="عرض الملف">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
