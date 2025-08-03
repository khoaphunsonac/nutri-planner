@extends('admin.layout')
@section('content')
     <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="">Dashboard</a></li>
            <li class="breadcrumb-item"> <a href="{{route('allergens.index')}}">Allergens Management</a></li>
            <li class="breadcrumb-item" aria-current="page"> Xem chi tiết Allergen</li>
        </ol>
    </nav>

    <div class="card shadow-sm">
        <div class="card-header">
            <h4>Chi tiết Allergen</h4>

        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{$item->id}}</p>
            <p><strong>Tên Allergen:</strong> {{$item->name}}</p>
            <p><strong>Trạng thái:</strong>
                @if ($item->deleted_at)
                    <span class="badge bg-danger">Đã xóa</span>
                @else
                    <span class="badge bg-success">Hoạt động</span>
                @endif 
            </p>
            <a href="{{route('allergens.edit',['allergen'=>$item])}}" class="btn btn-sm btn-warning rounded  me-2" title="Sửa"><i class="bi bi-pencil-square" > Chỉnh sửa</i></a>
            <a href="{{route('allergens.index')}}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại </a>
        </div>
    </div>
@endsection