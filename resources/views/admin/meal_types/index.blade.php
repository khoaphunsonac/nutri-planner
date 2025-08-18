@extends('admin.layout')
@section('content')
    <div class="container-fluid py-4">

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

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h4 class="mb-0 me-3">Quản lý loại bữa ăn</h4>
                <span class="badge bg-primary rounded-pill">{{ $items->total() }}</span>
                <small class="text-muted ms-2 d-none d-sm-inline">
                    <i class="bi bi-info-circle me-1"></i>Click vào tên để xem chi tiết
                </small>
            </div>
            <div class="d-flex gap-2">
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

        {{-- Summary --}}
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

        {{-- FILTER BAR (trên cùng) --}}
        <div class="col-12">
            <form method="get" class="card border-0 shadow-sm rounded-4 mb-3" role="search" aria-label="Bộ lọc">
                <div class="card-body">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-10">
                            <label class="form-label mb-1">Tìm nội dung</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input name="q" class="form-control border-0" placeholder="Tìm kiếm…"
                                    value="{{ request('q', $q ?? '') }}">
                            </div>
                        </div>

                       

                        {{-- Actions: Lọc giữ vị trí cũ, Reset ở dưới --}}
                        <div class="col-12 col-md-2 d-flex align-items-end">
                            <div class="w-100 d-flex flex-column gap-2">
                                <button class="btn btn-info text-white w-100" type="submit">
                                    <i class="bi bi-funnel me-1"></i> Lọc
                                </button>
                                @if (request()->hasAny(['q', 'from', 'to']))
                                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary w-100">Reset</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- LIST DẠNG TABLE --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:80px">#</th>
                                <th>Tên loại bữa ăn</th>
                                <th class="text-center" style="width:160px">Số món ăn</th>
                                <th style="width:180px">Ngày tạo</th>
                                <th class="text-end" style="width:160px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $index => $it)
                                @php
                                    $stt =
                                        method_exists($items, 'firstItem') && !is_null($items->firstItem())
                                            ? $items->firstItem() + $index
                                            : $loop->iteration;
                                @endphp
                                <tr>
                                    <td>{{ $stt }}</td>
                                    <td class="text-dark fw-normal" style="cursor:pointer"
                                        onclick="window.location='{{ route('admin.meal_types.show', $it->id) }}'">
                                        {{ $it->name }}
                                    </td>
                                    <td class="text-center">
                                        {{ $it->meals_count ?? 0 }}
                                    </td>
                                    <td class="text-muted">
                                        {{ $it->created_at?->format('d/m/Y H:i') ?? '—' }}
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.meal_types.show', $it->id) }}"
                                                class="btn btn-outline-secondary" title="Xem">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.meal_types.edit', $it->id) }}"
                                                class="btn btn-outline-info" title="Sửa">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('admin.meal_types.delete', $it->id) }}"
                                                class="btn btn-outline-danger" title="Xoá"
                                                onclick="return confirm('Xác nhận xoá?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Chưa có loại bữa ăn nào.
                                        <a href="{{ route('admin.meal_types.create') }}" class="ms-2">Thêm mới</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Phân trang --}}
                @if ($items->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-top">
                        <small class="text-muted">
                            Hiển thị {{ $items->firstItem() }}–{{ $items->lastItem() }} / {{ $items->total() }}
                        </small>
                        {{ $items->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
