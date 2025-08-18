@extends('admin.layout')
{{-- trường hợp muốn dữ tk đó lại nhưng lại muốn khoá ((: --}}
@section('content')
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
<div class="container mt-4" style="max-width: 600px;">


    <div class="bg-light p-4 rounded shadow">
        <h4 class="mb-4 text-warning fw-bold">
            <i class="bi bi-person-badge-fill me-2"></i>Chỉnh sửa tài khoản quản trị viên
        </h4>

        <form action="{{ route($shareUser . 'update', ['id' => $id]) }}" method="post">
            @csrf
            {{-- Username --}}
            <div class="mb-3">
                <label for="username" class="form-label">Quản trị viên</label>
                <input type="text" name="username" id="username" value="{{ old('username', $adminAccount->username ?? '') }}" class="form-control">
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $adminAccount->email ?? '') }}" class="form-control">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- chỉ khi muốn đổi mk mới nhập thôi --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới nếu muốn</label>
                <input type="text" name="password" id="password" class="form-control" placeholder="Để trống nếu không đổi mật khẩu">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Role --}}
            <div class="mb-3">
                <label class="form-label">Vai trò</label>
                <input type="text" name="role" value="{{ ucfirst($adminAccount->role ?? old('role')) }}" class="form-control bg-light" disabled>
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label d-block">
                    Trạng thái tài khoản:
                    <strong id="statusText" class="px-2 py-1 fs-6 {{ $adminAccount->status === 'active' ? 'text-success' : 'text-danger' }}">
                        {{ $adminAccount->status === 'active' ? 'Hoạt động' : 'Dừng hoạt động' }}
                    </strong>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary w-100">
                {{ $btnUpdate }}
            </button>
        </form>
        <div class="text-center">
            <a href="{{ route($shareUser.'index') }}" class="btn btn-secondary mt-3 rounded-pill">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
            </a>
        </div>
        {{-- thống báo --}}
        @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show mt-2">
            <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    </div>
</div>

@endsection
