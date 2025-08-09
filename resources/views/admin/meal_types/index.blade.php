@extends('admin.layout')
@section('content')
<div class="container py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb breadcrumb-compact">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}"><i class="bi bi-house-door"></i></a>
            </li>
            <li class="breadcrumb-item active">
                <i class="bi bi-collection me-1"></i>Loại bữa ăn
            </li>
        </ol>
    </nav>

    {{-- Compact Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center">
            <h4 class="mb-0 me-3">Quản lý loại bữa ăn</h4>
            <span class="badge bg-primary rounded-pill">{{ $items->total() }}</span>
            <small class="text-muted ms-2 d-none d-sm-inline">
                <i class="bi bi-info-circle me-1"></i>Click vào thẻ để xem chi tiết
            </small>
        </div>
        <div class="d-flex gap-2">
            {{-- Nút mở bộ lọc (hiện rõ trên mobile) --}}
            <button class="btn btn-outline-secondary btn-sm rounded-pill d-lg-none"
                    data-bs-toggle="collapse" data-bs-target="#filterPanel">
                <i class="bi bi-sliders"></i> Lọc
            </button>
            <a href="{{ route('admin.meal_types.create') }}" class="btn btn-primary btn-sm rounded-pill">
                <i class="bi bi-plus me-1"></i>Thêm loại bữa ăn
            </a>
        </div>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size:.7rem"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
            <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size:.7rem"></button>
        </div>
    @endif

    {{-- Dashboard summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm rounded-4">
                <div class="card-body">
                    <h4 class="mb-0">{{ $items->total() }}</h4>
                    <p class="text-muted mb-0">Tổng loại bữa ăn</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm rounded-4">
                <div class="card-body">
                    <h4 class="mb-0">{{ $activeCount ?? 0 }}</h4>
                    <p class="text-muted mb-0">Đang sử dụng</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm rounded-4">
                <div class="card-body">
                    <h4 class="mb-0">{{ $createdThisMonth ?? 0 }}</h4>
                    <p class="text-muted mb-0">Tạo mới tháng này</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- LEFT: Bộ lọc nâng cao (kiểu ô khoanh đỏ) --}}
        <div class="col-lg-3">
            <div id="filterPanel" class="collapse d-lg-block">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" disabled>
                                <i class="bi bi-funnel me-1"></i> Thêm điều kiện lọc
                            </button>
                        </div>
                        <button class="btn btn-sm btn-light d-lg-none" data-bs-toggle="collapse" data-bs-target="#filterPanel">
                            Đóng
                        </button>
                    </div>
                    <div class="card-body">
                        <form method="get" action="" role="search" aria-label="Bộ lọc nâng cao">
                            {{-- Từ khoá (giữ logic cũ) --}}
                            <div class="mb-3">
                                <label class="form-label">Từ khoá</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                    <input name="q" class="form-control" placeholder="Tìm theo tên…" value="{{ request('q', $q ?? '') }}">
                                </div>
                            </div>

                            {{-- Các filter bổ sung: có thể để trống (backend chưa xử lý cũng không sao) --}}
                            <div class="mb-3">
                                <label class="form-label">Danh mục</label>
                                <select name="category" class="form-select">
                                    <option value="">-- Chọn --</option>
                                    <option value="breakfast" @selected(request('category')==='breakfast')>Bữa sáng</option>
                                    <option value="lunch" @selected(request('category')==='lunch')>Bữa trưa</option>
                                    <option value="dinner" @selected(request('category')==='dinner')>Bữa tối</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Chọn --</option>
                                    <option value="active" @selected(request('status')==='active')>Hoạt động</option>
                                    <option value="deleted" @selected(request('status')==='deleted')>Đã xoá</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày tạo từ</label>
                                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">đến</label>
                                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary">
                                    <i class="bi bi-filter me-1"></i> Lọc
                                </button>
                            </div>

                            @if(request()->hasAny(['q','category','status','from','to']))
                                <div class="text-center mt-2">
                                    <a href="{{ url()->current() }}" class="small text-decoration-none">
                                        Xoá bộ lọc
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Tìm nhanh + Cards grid --}}
        <div class="col-lg-9">
            {{-- Thanh tìm nhanh (desktop) --}}
            <form method="get" class="mb-3 d-none d-lg-block" role="search" aria-label="Tìm nhanh">
                <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                    <input name="q" class="form-control border-0" placeholder="Nhập từ khoá cần tìm" value="{{ request('q', $q ?? '') }}">
                    <button class="btn btn-info text-white px-4" type="submit">
                        <i class="bi bi-search-heart me-1"></i> Tìm
                    </button>
                </div>
            </form>

            {{-- Cards grid (giữ nguyên routes/logic) --}}
            @if($items->count())
                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3">
                    @foreach($items as $it)
                        <div class="col">
                            <div class="card border-0 shadow-sm rounded-4 h-100 card-hover"
                                 role="button"
                                 onclick="window.location='{{ route('admin.meal_types.show', $it->id) }}'">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-dark-subtle text-dark-emphasis border">{{ $it->id }}</span>
                                        <small class="text-muted">{{ $it->created_at?->format('d/m/Y H:i') ?? '—' }}</small>
                                    </div>

                                    <h5 class="card-title mb-2">{{ $it->name }}</h5>
                                    <p class="card-text text-muted small mb-4">Loại bữa ăn • dùng để phân nhóm món</p>

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.meal_types.show', $it->id) }}"
                                           class="btn btn-outline-secondary btn-sm"
                                           title="Xem" aria-label="Xem"
                                           onclick="event.stopPropagation()">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.meal_types.edit', $it->id) }}"
                                           class="btn btn-outline-info btn-sm"
                                           title="Sửa" aria-label="Sửa"
                                           onclick="event.stopPropagation()">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('admin.meal_types.delete', $it->id) }}"
                                           class="btn btn-outline-danger btn-sm"
                                           title="Xoá" aria-label="Xoá"
                                           onclick="event.stopPropagation(); return confirm('Xác nhận xoá?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($items->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="small text-muted">
                            Hiển thị {{ $items->firstItem() }}–{{ $items->lastItem() }} / {{ $items->total() }}
                        </div>
                        {{ $items->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                {{-- Empty state --}}
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Chưa có dữ liệu
                    <div class="mt-2">
                        <a href="{{ route('admin.meal_types.create') }}" class="btn btn-sm btn-success rounded-pill">
                            <i class="bi bi-plus-circle me-1"></i> Thêm mới ngay
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Hover hiệu ứng nhẹ cho card --}}
<style>
.card-hover { transition: transform .15s ease, box-shadow .15s ease; }
.card-hover:hover { transform: translateY(-2px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.12); }
</style>
@endsection
