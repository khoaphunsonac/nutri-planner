@extends('admin.layout')
@section('content')
    <div class="container py-4">
        {{-- Breadcrumb --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb breadcrumb-compact">
        <li class="breadcrumb-item">
            <a href="#"><i class="bi bi-house-door"></i></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.meal_types.index') }}">
                <i class="bi bi-collection me-1"></i>Loại bữa ăn
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <i class="bi bi-chat-dots me-1"></i>Chi tiết
        </li>
    </ol>
</nav>


        {{-- 1) Header + Actions --}}
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="fs-5">📝</span>
                <h3 class="mb-0">
                    Chi tiết <span class="fw-semibold">Loại bữa ăn</span>
                    <span class="text-success">{{ $item->name }}</span>
                </h3>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.meal_types.index') }}" class="btn btn-light" title="Danh sách"
                    aria-label="Danh sách">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <a href="{{ route('admin.meal_types.edit', $item->id) }}" class="btn btn-outline-primary" title="Sửa"
                    aria-label="Sửa">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a href="{{ route('admin.meal_types.delete', $item->id) }}" class="btn btn-outline-danger"
                    onclick="return confirm('Xác nhận xoá?')" title="Xoá" aria-label="Xoá">
                    <i class="bi bi-trash"></i>
                </a>
            </div>
        </div>

        {{-- 2) Summary cards (đọc lướt rất nhanh) --}}
        @php
            $hasStatus = isset($item->is_active);
            $relatedCount =
                $relatedCount ??
                ($item->dishes_count ??
                    null ??
                    ((isset($relatedDishes)
                        ? (is_countable($relatedDishes)
                            ? count($relatedDishes)
                            : (method_exists($relatedDishes, 'count')
                                ? $relatedDishes->count()
                                : 0))
                        : $usedCount ?? null) ??
                        0));
        @endphp

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card shadow-sm rounded-4 h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">ID</div>
                        <div class="fs-5 fw-semibold">#{{ $item->id }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card shadow-sm rounded-4 h-100">
                    <div class="card-body py-3">
                        <div class="text-muted small">Tên</div>
                        <div class="fw-semibold text-success text-truncate" title="{{ $item->name }}">{{ $item->name }}
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        {{-- 3) Thông tin chi tiết (key–value rõ ràng) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h6 class="text-uppercase text-muted fw-semibold mb-3"><i class="bi bi-info-circle me-1"></i>Thông tin</h6>
                <div class="row gy-3">
                    
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="text-muted fw-medium" style="min-width:140px">Ngày tạo</div>
                            <div class="flex-grow-1">{{ $item->created_at?->format('d/m/Y H:i') ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <div class="text-muted fw-medium" style="min-width:140px">Cập nhật</div>
                            <div class="flex-grow-1">{{ $item->updated_at?->format('d/m/Y H:i') ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4) Món liên quan --}}
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:80px">#</th>
                                    <th>Tên món</th>
                                    <th class="text-muted">Cập nhật</th>
                                    <th class="text-end">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <style>
                                    /* Hiệu ứng hover */
                                    .clickable-row {
                                        cursor: pointer;
                                    }
                                    .clickable-row:hover {
                                        background-color: #f5f5f5;
                                    }
                                </style>
                                
                                @foreach ($relatedDishes as $index => $d)
                                <tr class="clickable-row" onclick="window.location='{{ route('meals.show', $d->id) }}'">
                                    {{-- STT theo trang nếu có paginate --}}
                                    <td>{{ ($relatedDishes->firstItem() ?? 0) + $index }}</td>
                                
                                    <td class="text-truncate" style="max-width:360px" title="{{ $d->name }}">
                                        {{ $d->name }}
                                    </td>
                                    <td class="text-muted">{{ $d->updated_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                
                                    <td class="text-end" onclick="event.stopPropagation()">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('meals.show', $d->id) }}"
                                               class="btn btn-outline-secondary" title="Xem">
                                              <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('meals.form', $d->id) }}"
                                               class="btn btn-outline-primary" title="Sửa">
                                              <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                
                                </tbody>
                                
                                </tbody>
                                
                            
                            </tbody>
                        </table>
                    </div>

                    {{-- Phân trang (nếu là paginator) --}}
                    
@if (method_exists($relatedDishes, 'hasPages') && $relatedDishes->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">
            Hiển thị {{ $relatedDishes->firstItem() }}–{{ $relatedDishes->lastItem() }} / {{ $relatedDishes->total() }}
        </small>

        @php
            $paginator = $relatedDishes;
            $elements  = $paginator->elements();
        @endphp

        @if ($paginator->hasPages())
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm justify-content-center mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link px-2"><i class="bi bi-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link px-2" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled"><span class="page-link px-2">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link px-2">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link px-2" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link px-2" href="{{ $paginator->nextPageUrl() }}" rel="next">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link px-2"><i class="bi bi-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
@endif


    {{-- polish nhỏ để đồng bộ và rõ ràng --}}
    <style>
        .fw-medium {
            font-weight: 500;
        }

        .card {
            border: 1px solid var(--bs-border-color-translucent);
        }
    </style>
@endsection
