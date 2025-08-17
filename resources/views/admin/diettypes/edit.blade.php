@extends('admin.layout')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('diettypes.index') }}">Quản lý loại chế độ ăn</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Chỉnh sửa loại chế độ ăn</h5>
            <a href="{{ route('diettypes.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left-circle"></i> Quay lại
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('diettypes.update', $diet->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Tên loại chế độ ăn</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $diet->name) }}" required>
                </div>
                <div class="mb-3">
        <label class="form-label fw-semibold">Chọn món ăn liên quan</label>
        <div class="row">
            @foreach($meals as $meal)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               name="meals[]"
                               value="{{ $meal->id }}"
                               id="meal_{{ $meal->id }}"
                               {{ in_array($meal->id, $diet->meals->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="meal_{{ $meal->id }}">
                            {{ $meal->name }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
            </form>
        </div>
    </div>
@endsection
