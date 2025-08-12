@extends('layouts.app')

@section('content')
<div class="content-wrapper" >
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تعديل مختبر</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('labs.index') }}">المختبرات</a></li>
                        <li class="breadcrumb-item active">تعديل مختبر</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">بيانات المختبر</h3>
                </div>
                <form action="{{ route('labs.update', $lab->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="building_id">المبنى</label>
                            <select class="form-control" name="building_id" required>
                                <option value="">اختر المبنى</option>
                                @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ $lab->building_id == $building->id ? 'selected' : '' }}>
                                        {{ $building->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room_number">رقم القاعة</label>
                            <input type="text" class="form-control" name="room_number" value="{{ $lab->room_number }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea class="form-control" name="description" rows="3">{{ $lab->description }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-warning">تحديث</button>
                        <a href="{{ route('labs.index') }}" class="btn btn-secondary">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
