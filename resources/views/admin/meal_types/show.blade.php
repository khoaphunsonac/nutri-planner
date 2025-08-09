@extends('admin.layout')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Chi tiết loại bữa ăn</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.meal-types.index') }}" class="btn btn-secondary" title="Danh sách">
                <i class="bi bi-arrow-left"></i>
            </a>
            <a href="{{ route('admin.meal-types.edit', $item->id) }}" class="btn btn-info" title="Sửa" aria-label="Sửa">
                <i class="bi bi-pencil-square"></i>
            </a>
            <form action="{{ route('admin.meal-types.destroy', $item->id) }}" method="post" class="d-inline"
                  onsubmit="return confirm('Xác nhận xoá?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger" title="Xoá" aria-label="Xoá">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $item->id }}</dd>

                <dt class="col-sm-3">Tên loại</dt>
                <dd class="col-sm-9">{{ $item->name }}</dd>

                <dt class="col-sm-3">Ngày tạo</dt>
                <dd class="col-sm-9">{{ $item->created_at?->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Cập nhật</dt>
                <dd class="col-sm-9">{{ $item->updated_at?->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
</div>
@endsection
