@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>قائمة المختبرات</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">المختبرات</h3>
                    <a href="{{ route('labs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة مختبر
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المبنى</th>
                                <th>رقم القاعة</th>
                                <th>الوصف</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($labs as $index => $lab)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $lab->building->name ?? 'غير محدد' }}</td>
                                    <td>{{ $lab->room_number }}</td>
                                    <td>{{ $lab->description }}</td>
                                    <td>

                                        <a href="{{ route('labs.edit', $lab->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                                        <form action="{{ route('labs.destroy', $lab->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($labs->isEmpty())
                                <tr>
                                    <td colspan="5">لا توجد بيانات</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
