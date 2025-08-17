@extends('admin.layout')

@section('content')
<div class="container-fluid">
    {{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb breadcrumb-compact">
        <li class="breadcrumb-item">
            <a href="#"><i class="bi bi-house-door"></i></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('users.index') }}"><i class="bi bi-people-fill me-1"></i>Users Management</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="bi bi-list-ul me-1"></i>Danh sách
        </li>
    </ol>
</nav>
{{-- chi tiết món khi ấn vào --}}
    <div class="row">
        <div class="col-md-12">
            @if (!empty($users))
                <div class="card shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-3">🍽️ Các món ăn được người dùng này yêu thích:</h5>
                        <a href="{{ route('users.form', $id) }}" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left"></i> Quay lại</a>
                    </div>
                    <div class="list-group">
                        @forelse ($users->savemeal_preview as $meal)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $meal->name }}</span>
                            </div>
                        @empty
                            <div class="text-muted">Chưa chọn món yêu thích nào</div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
