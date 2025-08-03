@extends('admin.layout')
@section('content')
     <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="">Tags Management</a></li>
            <li class="breadcrumb-item" aria-current="page"> Xem chi tiết Tag</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Chi tiết Tag</h4>

        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{$item->id}}</p>
            <p><strong>Tên Tag:</strong> {{$item->name}}</p>
            <p><strong>Trạng thái:</strong>
                @if ($item->deleted_at)
                    <span class="badge bg-danger">Đã xóa</span>
                @else
                    <span class="badge bg-success">Hoạt động</span>
                @endif 
            </p>
            <a href="{{route('tags.edit',['tag'=>$item])}}" class="btn btn-sm btn-warning rounded  me-2" title="Sửa"><i class="bi bi-pencil-square" > Chỉnh sửa</i></a>
            <a href="{{route('tags.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
        </div>
    </div>
@endsection