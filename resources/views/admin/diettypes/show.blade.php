@extends('Admin.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Chi tiết Chế độ ăn</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Tên:</strong> {{ $diet->name }}</p>
            <p><strong>Calories:</strong> {{ $diet->calo }}</p>
            <a href="{{ route('diettypes.edit', $diet->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Chỉnh sửa</a>
            <a href="{{ route('diettypes.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection
