@extends('layouts.app')

@section('content')
    <h1>تفاصيل المختبر</h1>

    <p><strong>المبنى:</strong> {{ $lab->building->name ?? 'غير محدد' }}</p>
    <p><strong>رقم الغرفة:</strong> {{ $lab->room_number }}</p>
    <p><strong>الوصف:</strong> {{ $lab->description }}</p>

    <a href="{{ route('labs.index') }}">عودة إلى القائمة</a>
@endsection
