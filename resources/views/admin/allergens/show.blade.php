@extends('admin.layout')
@section('content')
     <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Quản lý Dị ứng</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> Xem chi tiết Dị ứng</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📝 Thông tin chi tiết Dị ứng</h5>
            <div>
                <a href="{{ route('allergens.form', ['id' => $item->id]) }}" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                </a>
                <a href="{{ route('allergens.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $item->id }}</p>
            <p><strong>Tên Dị ứng:</strong> {{ $item->name }}</p>
            <p><strong>Trạng thái:</strong>
                @if ($item->deleted_at)
                    <span class="badge bg-danger">Đã xóa</span>
                @else
                    <span class="badge bg-success">Hoạt động</span>
                @endif
            </p>
            <p><strong>Tổng số món ăn được gán:</strong> {{ $item->meals->count() }}</p>

            <hr>

            @if($item->meals->count() > 0)
                <h5 class="mb-3"><i class="bi bi-list-ul"></i> Các món ăn được gán với Dị ứng này:</h5>

                <div class="row">
                    @foreach($items->meals as $meal)
                        <div class="col-md-6 mb-3">
                            <div class="list-group-item shadow-sm rounded px-3 py-2 d-flex justify-content-between align-items-center" 
                                        style="transition: background-color 0.2s; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#f8f9fa';"
                                        onmouseout="this.style.backgroundColor='white';">
                                <div >
                                    <div class="fw-bold">{{ $meal->name }}</div>
                                    <small class="text-muted">ID: {{ $meal->id }}</small>
                                </div>
                                <span class="badge bg-info">{{ $meal->mealType->name ?? 'Không rõ loại' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-muted mt-3">
                    <em>Dị ứng này hiện chưa được gán với món ăn nào.</em>
                </div>
            @endif
        </div>
    </div>
@endsection