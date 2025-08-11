@extends('admin.layout')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            {{ $mode === 'create' ? 'Thêm loại bữa ăn' : 'Sửa loại bữa ăn' }}
        </h4>
        <a href="{{ route('admin.meal_types.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <form method="post"
          action="{{ $mode === 'create'
                    ? route('admin.meal_types.store')
                    : route('admin.meal_types.update', $item->id) }}">
        @csrf
        {{-- Route update dùng POST nên KHÔNG spoof PUT --}}

        <div class="mb-3">
            <label class="form-label">Tên loại bữa ăn</label>
            <input name="name" class="form-control"
                   value="{{ old('name', $item->name ?? '') }}"
                   required maxlength="100" placeholder="Ví dụ: Breakfast">
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">
                {{ $mode === 'create' ? 'Lưu' : 'Cập nhật' }}
            </button>
            <a href="{{ route('admin.meal_types.index') }}" class="btn btn-outline-secondary">Huỷ</a>
        </div>
    </form>
</div>
@endsection
