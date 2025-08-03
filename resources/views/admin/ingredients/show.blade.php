@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        {{-- Compact Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('ingredients.index') }}">Nguyên liệu</a>
                </li>
                <li class="breadcrumb-item active">{{ $ingredient->name }}</li>
            </ol>
        </nav>

        {{-- Header with Actions --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Chi tiết nguyên liệu</h4>
            <div class="btn-group btn-group-sm">
                <a href="{{ route('ingredients.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                </a>
                <a href="{{ route('ingredients.edit', $ingredient->id) }}" class="btn btn-outline-warning">
                    <i class="bi bi-pencil me-1"></i>Chỉnh sửa
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Main Info Card --}}
            <div class="col-md-8">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>Thông tin cơ bản
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label text-muted small">Tên nguyên liệu</label>
                                <div class="fw-bold fs-5 text-primary">{{ $ingredient->name }}</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small">Đơn vị tính</label>
                                <div class="fw-medium">
                                    <span class="badge bg-light text-dark px-3 py-2">{{ $ingredient->unit ?: 'g' }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-muted small">ID nguyên liệu</label>
                                <div class="text-muted">#{{ $ingredient->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Nutrition Card --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-heart-pulse me-2"></i>Thông tin dinh dưỡng
                            <small class="opacity-75">(trên 100{{ $ingredient->unit ?: 'g' }})</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="nutrition-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-lightning text-warning me-2"></i>
                                        <span class="text-muted small">Protein</span>
                                    </div>
                                    <div class="fw-bold fs-4 text-warning">{{ number_format($ingredient->protein, 1) }}
                                    </div>
                                    <small class="text-muted">gram</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="nutrition-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-lightning text-success me-2"></i>
                                        <span class="text-muted small">Carbohydrate</span>
                                    </div>
                                    <div class="fw-bold fs-4 text-success">{{ number_format($ingredient->carb, 1) }}</div>
                                    <small class="text-muted">gram</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="nutrition-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-lightning text-danger me-2"></i>
                                        <span class="text-muted small">Chất béo</span>
                                    </div>
                                    <div class="fw-bold fs-4 text-danger">{{ number_format($ingredient->fat, 1) }}</div>
                                    <small class="text-muted">gram</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="nutrition-item">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-fire text-primary me-2"></i>
                                        <span class="text-muted small">Tổng Calo</span>
                                    </div>
                                    <div class="fw-bold fs-4 text-primary">{{ number_format($ingredient->calo, 0) }}</div>
                                    <small class="text-muted">kcal</small>
                                </div>
                            </div>
                        </div>

                        {{-- Nutrition Bar Chart --}}
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">Phân bố dinh dưỡng</h6>
                            @php
                                $total = $ingredient->protein + $ingredient->carb + $ingredient->fat;
                                $proteinPercent = $total > 0 ? ($ingredient->protein / $total) * 100 : 0;
                                $carbPercent = $total > 0 ? ($ingredient->carb / $total) * 100 : 0;
                                $fatPercent = $total > 0 ? ($ingredient->fat / $total) * 100 : 0;
                            @endphp
                            <div class="nutrition-chart">
                                <div class="d-flex mb-2"
                                    style="height: 20px; border-radius: 10px; overflow: hidden; background-color: #e9ecef;">
                                    @if ($proteinPercent > 0)
                                        <div class="bg-warning" style="width: {{ $proteinPercent }}%;"
                                            title="Protein {{ number_format($proteinPercent, 1) }}%"></div>
                                    @endif
                                    @if ($carbPercent > 0)
                                        <div class="bg-success" style="width: {{ $carbPercent }}%;"
                                            title="Carb {{ number_format($carbPercent, 1) }}%"></div>
                                    @endif
                                    @if ($fatPercent > 0)
                                        <div class="bg-danger" style="width: {{ $fatPercent }}%;"
                                            title="Fat {{ number_format($fatPercent, 1) }}%"></div>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between small text-muted">
                                    <span><i class="bi bi-square-fill text-warning"></i> Protein
                                        {{ number_format($proteinPercent, 1) }}%</span>
                                    <span><i class="bi bi-square-fill text-success"></i> Carb
                                        {{ number_format($carbPercent, 1) }}%</span>
                                    <span><i class="bi bi-square-fill text-danger"></i> Fat
                                        {{ number_format($fatPercent, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-md-4">
                {{-- Quick Stats --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-graph-up me-2"></i>Thống kê nhanh
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-primary">{{ number_format($ingredient->calo, 0) }}</div>
                                    <small class="text-muted">Calo/100g</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-success">
                                        {{ number_format($ingredient->protein + $ingredient->carb + $ingredient->fat, 1) }}
                                    </div>
                                    <small class="text-muted">Tổng macro</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Calculation Formula --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-calculator me-2"></i>Công thức tính Calo
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Protein:</span>
                                <span>{{ number_format($ingredient->protein, 1) }} × 4 =
                                    <strong>{{ number_format($ingredient->protein * 4, 1) }}</strong></span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Carb:</span>
                                <span>{{ number_format($ingredient->carb, 1) }} × 4 =
                                    <strong>{{ number_format($ingredient->carb * 4, 1) }}</strong></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Fat:</span>
                                <span>{{ number_format($ingredient->fat, 1) }} × 9 =
                                    <strong>{{ number_format($ingredient->fat * 9, 1) }}</strong></span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Tổng cộng:</span>
                                <span class="text-primary">{{ number_format($ingredient->calo, 1) }} kcal</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Meta Info --}}
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="bi bi-clock me-2"></i>Thông tin khác
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Ngày tạo:</span>
                                <span>{{ $ingredient->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Cập nhật:</span>
                                <span>{{ $ingredient->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
