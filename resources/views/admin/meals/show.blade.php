@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb breadcrumb-compact">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('meals.index') }}">Món ăn</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $meal->name }}
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Chi tiết món ăn</h4>
            <div>
                <a href="{{ route('meals.form', $meal->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="bi bi-pencil me-1"></i>Chỉnh sửa
                </a>
                <a href="{{ route('meals.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Quay lại
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Left Column - Main Info --}}
            <div class="col-md-8">
                {{-- Basic Information --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Thông tin cơ bản</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Tên món ăn:</td>
                                        <td>{{ $meal->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Loại bữa ăn:</td>
                                        <td><span class="badge bg-info">{{ $meal->mealType->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Chế độ ăn:</td>
                                        <td><span class="badge bg-success">{{ $meal->dietType->name ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Ngày tạo:</td>
                                        <td>{{ $meal->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                @if ($meal->image_url)
                                    <div class="text-center">
                                        <img src="{{ asset('uploads/meals/' . $meal->image_url) }}"
                                            alt="{{ $meal->name }}" class="img-fluid rounded shadow"
                                            style="max-height: 200px;">
                                    </div>
                                @else
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <p>Chưa có hình ảnh</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($meal->description)
                            <div class="mt-3">
                                <h6>Mô tả:</h6>
                                <p class="text-muted">{{ $meal->description }}</p>
                            </div>
                        @endif

                        @if ($meal->preparation)
                            <div class="mt-3">
                                <h6>Cách chế biến:</h6>
                                <div class="bg-light p-3 rounded">
                                    <pre class="mb-0" style="white-space: pre-wrap;">{{ $meal->preparation }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Recipe Ingredients --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0"><i class="bi bi-basket me-1"></i>Nguyên liệu công thức</h6>
                    </div>
                    <div class="card-body">
                        @if ($meal->recipeIngredients->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nguyên liệu</th>
                                            <th width="100" class="text-center">Số lượng</th>
                                            <th width="80" class="text-center">Đơn vị</th>
                                            <th width="80" class="text-center">Protein</th>
                                            <th width="80" class="text-center">Carb</th>
                                            <th width="80" class="text-center">Fat</th>
                                            <th width="80" class="text-center">Calo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($meal->recipeIngredients as $recipeIngredient)
                                            @php
                                                $ingredient = $recipeIngredient->ingredient;
                                                $quantity = $recipeIngredient->quantity;
                                                $factor = $quantity / 100; // Convert to per 100g ratio
                                            @endphp
                                            <tr>
                                                <td class="fw-medium">{{ $ingredient->name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ number_format($quantity, 1) }}</td>
                                                <td class="text-center">{{ $ingredient->unit ?? 'g' }}</td>
                                                <td class="text-center">
                                                    {{ number_format(($ingredient->protein ?? 0) * $factor, 1) }}g</td>
                                                <td class="text-center">
                                                    {{ number_format(($ingredient->carb ?? 0) * $factor, 1) }}g</td>
                                                <td class="text-center">
                                                    {{ number_format(($ingredient->fat ?? 0) * $factor, 1) }}g</td>
                                                <td class="text-center">
                                                    {{ number_format($recipeIngredient->total_calo ?? 0, 0) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-basket3 fs-3 d-block mb-2"></i>
                                <p class="mb-0">Chưa có nguyên liệu nào</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column - Stats & Additional Info --}}
            <div class="col-md-4">
                {{-- Nutrition Summary --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0"><i class="bi bi-heart-pulse me-1"></i>Thông tin dinh dưỡng</h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $nutrition = $meal->total_nutrition;
                        @endphp
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h5 class="text-primary mb-1">{{ number_format($nutrition['calories'] ?? 0, 0) }}</h5>
                                    <small class="text-muted">Calories</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h5 class="text-warning mb-1">{{ number_format($nutrition['protein'] ?? 0, 1) }}g</h5>
                                    <small class="text-muted">Protein</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h5 class="text-success mb-1">{{ number_format($nutrition['carb'] ?? 0, 1) }}g</h5>
                                    <small class="text-muted">Carbohydrate</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-2">
                                    <h5 class="text-danger mb-1">{{ number_format($nutrition['fat'] ?? 0, 1) }}g</h5>
                                    <small class="text-muted">Fat</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="bi bi-tags me-1"></i>Tags</h6>
                    </div>
                    <div class="card-body">
                        @if ($meal->tags->count() > 0)
                            @foreach ($meal->tags as $tag)
                                <span class="badge bg-primary me-1 mb-1">{{ $tag->name }}</span>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Chưa có tag nào</p>
                        @endif
                    </div>
                </div>

                {{-- Allergens --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-1"></i>Chất gây dị ứng</h6>
                    </div>
                    <div class="card-body">
                        @if ($meal->allergens->count() > 0)
                            @foreach ($meal->allergens as $allergen)
                                <span class="badge bg-warning text-dark me-1 mb-1">{{ $allergen->name }}</span>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Không có chất gây dị ứng</p>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="bi bi-graph-up me-1"></i>Thống kê</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-12 mb-3">
                                <h5 class="text-primary">{{ $meal->recipeIngredients->count() }}</h5>
                                <small class="text-muted">Nguyên liệu</small>
                            </div>
                            <div class="col-6">
                                <h6 class="text-success">{{ $meal->tags->count() }}</h6>
                                <small class="text-muted">Tags</small>
                            </div>
                            <div class="col-6">
                                <h6 class="text-warning">{{ $meal->allergens->count() }}</h6>
                                <small class="text-muted">Allergens</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
