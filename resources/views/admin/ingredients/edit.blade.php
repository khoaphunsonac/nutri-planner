@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <h2><i class="bi bi-pencil me-2"></i>Cập nhật nguyên liệu</h2>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Có lỗi xảy ra:</strong>
                </div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="ingredients-card card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Thông tin nguyên liệu</h5>
                        <span class="badge bg-primary">ID: {{ $ingredient->id }}</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('ingredients.update', $ingredient->id) }}">
                            @csrf
                            @method('PUT')
                            @include('admin.ingredients.form', ['ingredient' => $ingredient])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
