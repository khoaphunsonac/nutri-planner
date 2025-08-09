@extends('admin.layout')
@section('content')
    {{-- Breadcrumb --}}
     <nav aria-label="breadcrumb breadcrumb-compact" class="mb-4">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}"><i class="bi bi-tags">Thẻ</i></a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
        </ol>
    </nav>
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">📝 Thông tin chi tiết <span class="fw-semibold text-success">Thẻ {{ $item->name }} </span> </h5>
            <div>
                <a href="{{ route('tags.form', ['id' => $item->id]) }}" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                </a>
                <a href="{{ route('tags.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
            </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $item->id }}</p>
            <p><strong>Tên Thẻ:</strong> <span class="text-success">Thẻ {{ $item->name }} </span></p>
            <p><strong>Trạng thái:</strong>
                @if ($item->deleted_at)
                    <span class="badge bg-danger">Đã xóa</span>
                @else
                    <span class="badge bg-success">Hoạt động</span>
                @endif
            </p>
            <p><strong>Tổng số món ăn được gán:</strong> {{ $item->meals->count() }}</p>

            <hr>
{{-- 
            @if ($item->meals->count())
                <h6><i class="bi bi-list-ul"></i> Danh sách món ăn:</h6>
                <ul class="list-group list-group-flush mt-2">
                    @foreach ($item->meals as $meal)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $meal->name }}
                            <span class="badge bg-primary rounded-pill">ID: {{ $meal->id }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted fst-italic">Chưa gán với món ăn nào.</p>
            @endif --}}

            {{-- Nếu có meal được gán --}}
            <div class="container mt-4">
                @if($item->meals->count() > 0)
                
                    <div class="row  mt-4">
                        <h5 class="">Các món ăn được gán với Thẻ này: </h5>
                        <ul class="list-group w-100" style="max-width: 1000px;">
                            @foreach($item->meals as $meal)
                                <div class="col-md-6 mb-3">
                                    <a href="{{ route('meals.show', $meal->id) }}" class="text-decoration-none text-dark">
                                        <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded  ">
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
                    Thẻ này hiện chưa được gán với món ăn nào.
                    </div>
                @endif
            </div>
    </div>
</div>

@endsection