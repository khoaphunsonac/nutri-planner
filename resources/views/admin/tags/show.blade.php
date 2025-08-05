@extends('admin.layout')
@section('content')
     <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('tags.index')}}">Tags Management</a></li>
            <li class="breadcrumb-item link-primary" aria-current="page"> Xem chi tiết Tag</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📝 Thông tin chi tiết Tag</h5>
            <div>
                <a href="{{ route('tags.form', ['id' => $item->id]) }}" class="btn btn-sm btn-warning me-2">
                    <i class="bi bi-pencil-square"></i> Chỉnh sửa
                </a>
                <a href="{{ route('tags.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{ $item->id }}</p>
            <p><strong>Tên Tag:</strong> {{ $item->name }}</p>
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
                        <h5 class="">Các món ăn được gán với tag này: </h5>
                        <ul class="list-group w-100" style="max-width: 1000px;">
                            @foreach($item->meals as $meal)
                                <div class="col-md-6 mb-3">
                                    <div class="list-group-item d-flex justify-content-between align-items-center shadow-sm rounded  ">
                                        <span class="text-truncate">{{ $meal->name }}</span>
                                        <span class="badge bg-info">{{ $meal->mealType->name ?? 'Không rõ loại' }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                
                @else
                    <div class="text-muted mt-3">
                        Tag này hiện chưa được gán với món ăn nào.
                    </div>
                @endif
            </div>
    </div>
</div>

@endsection