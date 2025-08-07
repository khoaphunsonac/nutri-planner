@extends('admin.layout')

@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item">
                <a href="#"><i class="bi bi-house-door"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('diettypes.index') }}">Loại chế độ ăn</a>
            </li>
            <li class="breadcrumb-item active">{{ $diet->name }}</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Chi tiết loại chế độ ăn</h4>
        <a href="{{ route('diettypes.edit', $diet->id) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil-square me-1"></i>Chỉnh sửa
        </a>
    </div>

    {{-- Thông tin chính --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $diet->id }}</p>
            <p><strong>Tên loại:</strong> {{ $diet->name }}</p>
        </div>
    </div>

    {{-- Danh sách các món ăn --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Danh sách món ăn thuộc chế độ này</h5>
        </div>

        <div class="card-body p-0">
            @if ($diet->meals->isEmpty())
                <p class="p-3 text-muted mb-0">Không có món ăn nào thuộc loại chế độ này.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>Tên món ăn</th>
                                <th>Hình ảnh</th>
                                <th>Mô tả</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diet->meals as $meal)
                                <tr>
                                    <td>{{ $meal->id }}</td>
                                    <td>{{ $meal->name }}</td>
                                    <td>
                                        @if ($meal->image_url)
                                            <img src="{{ $meal->image_url }}" alt="Ảnh" style="max-height: 50px;">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $meal->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
