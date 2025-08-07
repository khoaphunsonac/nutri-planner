@extends('admin.layout')
@section('content')
    
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item"><a href="#"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}"><i class="bi bi-exclamation-triangle">Dị ứng</i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
        </ol>
    </nav>
     {{-- Header --}}
     <div class=" d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">📝 Thông tin chi tiết Dị ứng <span class="fw-semibold text-success"> {{ $item->name }} </span></h5>
            <div>
                <a href="{{ route('allergens.form', ['id' => $item->id]) }}" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                </a>
                <a href="{{ route('allergens.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    <div class=" card shadow-sm border-0">
        
        <div class="card-body">
            <p><strong>ID:</strong> {{ $item->id }}</p>
            <p><strong>Tên Dị ứng:</strong> <span class="text-success">{{ $item->name }} </span></p>
            <p><strong>Trạng thái:</strong>
                @if ($item->deleted_at)
                    <span class="badge bg-danger">Đã xóa</span>
                @else
                    <span class="badge bg-success">Hoạt động</span>
                @endif
            </p>
            <p><strong>Tổng số món ăn được gán:</strong> {{ $item->meals->count() }}</p>

            <hr>

            <div class="container mt-4">
                @if($item->meals->count() > 0)
                    

                    <div class="row mt-4">
                        <h5 class="mb-3"><i class="bi bi-list-ul"></i> Các món ăn được gán với Dị ứng này:</h5>
                        <ul class="list-group w-100" style="max-width: 1000px;">
                            @foreach($items->meals as $meal)
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('meals.show', $meal->id) }}" class="text-decoration-none text-dark" >
                                        <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm  hover-shadow rounded  ">
                                            <span class="text-truncate">{{ $meal->name }}</span>
                                            <span class="badge bg-info">{{ $meal->mealType->name ?? 'Không rõ loại' }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                         </ul>
                    </div>
                @else
                    <div class="text-muted mt-3">
                        <em>Dị ứng này hiện chưa được gán với món ăn nào.</em>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
@endsection