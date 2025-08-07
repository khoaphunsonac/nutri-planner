@extends('admin.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Chi tiết liên hệ</h2>

    <div class="row mb-3">
        <div class="col-md-6">
            <label><strong>Họ tên:</strong></label>
            <p>{{ $item->name }}</p>
        </div>
        <div class="col-md-6">
            <label><strong>Email:</strong></label>
            <p>{{ $item->email }}</p>
        </div>
    </div>

    <div class="mb-3">
        <label><strong>Nội dung liên hệ:</strong></label>
        <div class="border rounded p-3 bg-light">
            {{ $item->message }}
        </div>
    </div>

    <div class="mb-3">
        <label><strong>Thời gian gửi:</strong></label>
        <p>{{ $item->created_at ? $item->created_at->format('H:i d/m/Y') : 'Không rõ' }}</p>
    </div>

    <a href="{{ route('contact.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>
</div>
@endsection
