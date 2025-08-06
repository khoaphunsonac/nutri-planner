@extends('admin.layout')
@section('content')
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item">
                <a href="#"><i class="bi bi-house-door"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('ingredients.index') }}">Nguyên liệu</a>
            </li>
            <li class="breadcrumb-item active">
                Danh sách
            </li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Quản lý nguyên liệu</h2>
        <a href="{{ route('ingredients.add') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Thêm nguyên liệu mới</a>
    </div>


    @if (session('success'))
        <div class="alert alert-success mt-2 text-center" style="width: 350px;">{{ session('success') }}</div>
    @endif
    {{-- Dashboard summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{ $totalIngredients ?? 0 }}</h4>
                    <p class="text-muted mb-0">Tổng Nguyên liệu</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{ $activeIngredients ?? 0 }}</h4>
                    <p class="text-muted mb-0">Đang hoạt động</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center -shadow-sm">
                <div class="card-body">
                    <h4>{{ $usageRate ?? 0 }}</h4>
                    <p class="text-muted mb-0">Sử dụng</p>
                </div>
            </div>
        </div>
    </div>

    {{-- fillter form --}}
    <form action="" method="GET" class="row g-2 align-items-center mb-5">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" id="" placeholder="Tìm kiếm nguyên liệu..."
                value="{{ $search ?? old('search') }}">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100" type="submit">Lọc</button>
        </div>

    </form>
    {{-- Ingredient table --}}
    <div class="table-reponsive">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Danh sách Nguyên liệu</h5>
            <small>
                {{--  Tổng số ingredient thỏa query tìm kiếm --}}
                @if ($ingredients->total() > 0)
                    Tổng: {{ $ingredients->total() }} mục
                @else
                    Không có kết quả nào
                @endif
            </small>
        </div>
        <div class="card-body text-center">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th width="200">Tên Nguyên liệu</th>
                        <th width="80">Đơn vị</th>
                        <th width="80">Protein</th>
                        <th width="80">Carb</th>
                        <th width="80">Fat</th>
                        <th width="80">Calo</th>
                        <th width="200" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @if (count($ingredients) > 0)
                        @foreach ($ingredients as $ingredient)
                            <tr style="cursor: pointer;">
                                <td class="align-middle text-center">
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <span
                                            class="d-inline-block px-2 py-1 border rounded bg-light sort-order text-center"
                                            style="width:50px">{{ $ingredient->id }} </span>
                                    </a>
                                </td>
                                <td class="text-start">
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <strong>{{ $ingredient->name }}</strong>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <span class="badge bg-secondary">{{ $ingredient->unit }}</span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <span class="text-warning">{{ $ingredient->protein }}g</span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <span class="text-success">{{ $ingredient->carb }}g</span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <span class="text-danger">{{ $ingredient->fat }}g</span>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                        class="text-decoration-none text-dark d-block">
                                        <span class="text-primary fw-bold">{{ $ingredient->calo }} kcal</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('ingredients.show', ['id' => $ingredient->id]) }}"
                                            class="btn btn-sm btn-info rounded me-3" title="Chi tiết"><i
                                                class="bi bi-eye"></i></a>
                                        <a href="{{ route('ingredients.form', ['id' => $ingredient->id]) }}"
                                            class="btn btn-sm btn-warning rounded me-3" title="Sửa"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form action="{{ route('ingredients.delete', ['id' => $ingredient->id]) }}"
                                            method="POST" style="display:inline-block"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa nguyên liệu này không?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger rounded me-3" title="Xóa"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center text-muted" colspan="8">Không có nguyên liệu nào</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $ingredients->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

