@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        {{-- Compact Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ingredients.index') }}">Nguyên liệu</a>
                </li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </nav>

        {{-- Compact Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Thêm nguyên liệu mới</h4>
            <a href="{{ route('ingredients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Quay lại
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Có lỗi:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach ($errors->all() as $error)
                        <li><small>{{ $error }}</small></li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Compact Form --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('ingredients.store') }}">
                    @csrf
                    @include('admin.ingredients.form', ['ingredient' => null])
                </form>
            </div>
        </div>
    </div>
@endsection
