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
                    {{ isset($meal) && $meal ? 'Sửa: ' . $meal->name : 'Thêm mới' }}
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                {{ isset($meal) && $meal ? 'Cập nhật món ăn' : 'Thêm món ăn mới' }}
            </h4>
            <a href="{{ route('meals.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Quay lại
            </a>
        </div>

        {{-- Error Messages Section - Thay thế phần @if ($errors->any()) hiện tại --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                    <div class="flex-grow-1">
                        <strong>Có {{ $errors->count() }} lỗi cần được khắc phục:</strong>
                        <hr class="my-2">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Custom error message cho specific errors --}}
        {{-- @if ($errors->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <strong>Lỗi hệ thống:</strong>
                </div>
                <div class="mt-1">{{ $errors->first('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        {{-- Ingredients Errors với chi tiết hơn --}}
        {{-- @error('ingredients')
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-1"></i>
                <strong>Lỗi nguyên liệu:</strong> {{ $message }}
            </div>
        @enderror

        @if ($errors->has('ingredients.*'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-1"></i>
                <strong>Chi tiết lỗi nguyên liệu:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->get('ingredients.*') as $field => $messages)
                        @foreach ($messages as $message)
                            <li>
                                @if (str_contains($field, 'ingredient_id'))
                                    <strong>Nguyên liệu:</strong> {{ $message }}
                                @elseif (str_contains($field, 'quantity'))
                                    <strong>Số lượng:</strong> {{ $message }}
                                @else
                                    {{ $message }}
                                @endif
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif --}}

        {{-- Preparation Steps Errors --}}
        {{-- @if ($errors->has('preparation_steps.*'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-1"></i>
                <strong>Lỗi bước chế biến:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->get('preparation_steps.*') as $field => $messages)
                        @foreach ($messages as $message)
                            @php
                                // Extract step number from field name like "preparation_steps.0"
                                preg_match('/preparation_steps\.(\d+)/', $field, $matches);
                                $stepNumber = isset($matches[1]) ? $matches[1] + 1 : '?';
                            @endphp
                            <li><strong>Bước {{ $stepNumber }}:</strong> {{ $message }}</li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('meals.save') }}" method="POST" id="mealForm" enctype="multipart/form-data">
                    @csrf
                    @if (isset($meal) && $meal)
                        <input type="hidden" name="id" value="{{ $meal->id }}">
                    @endif

                    <div class="row">
                        {{-- Left Column --}}
                        <div class="col-md-6">
                            {{-- Meal Name với error styling --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên món ăn <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $meal->name ?? '') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Meal Type với error styling --}}
                            <div class="mb-3">
                                <label for="meal_type_id" class="form-label">Loại bữa ăn <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('meal_type_id') is-invalid @enderror" id="meal_type_id"
                                    name="meal_type_id">
                                    <option value="">Chọn loại bữa ăn</option>
                                    @foreach ($mealTypes as $mealType)
                                        <option value="{{ $mealType->id }}"
                                            {{ old('meal_type_id', $meal->meal_type_id ?? '') == $mealType->id ? 'selected' : '' }}>
                                            {{ $mealType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('meal_type_id')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Diet Type với error styling --}}
                            <div class="mb-3">
                                <label for="diet_type_id" class="form-label">Chế độ ăn <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('diet_type_id') is-invalid @enderror" id="diet_type_id"
                                    name="diet_type_id">
                                    <option value="">Chọn chế độ ăn</option>
                                    @foreach ($dietTypes as $dietType)
                                        <option value="{{ $dietType->id }}"
                                            {{ old('diet_type_id', $meal->diet_type_id ?? '') == $dietType->id ? 'selected' : '' }}>
                                            {{ $dietType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('diet_type_id')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Image Upload với error styling --}}
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh món ăn</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                <div class="form-text">Chọn file hình ảnh (JPG, PNG, GIF, WEBP) - Tối đa 2MB, kích thước
                                    100x100px đến 2000x2000px</div>
                                @error('image')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror

                                {{-- Current Image Preview --}}
                                @if (isset($meal) && $meal && $meal->image_url)
                                    <div class="mt-2" id="currentImage">
                                        <small class="text-muted">Hình ảnh hiện tại:</small>
                                        <div class="border rounded p-2 mt-1">
                                            <img src="{{ asset('uploads/meals/' . $meal->image_url) }}"
                                                alt="{{ $meal->name }}" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    </div>
                                @endif

                                {{-- New Image Preview --}}
                                <div class="mt-2" id="imagePreview" style="display: none;">
                                    <small class="text-muted">Hình ảnh mới:</small>
                                    <div class="border rounded p-2 mt-1">
                                        <img id="previewImg" src="" alt="Preview" class="img-thumbnail"
                                            style="max-height: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="col-md-6">
                            {{-- Description với error styling --}}
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                @csrf
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="12" placeholder="Mô tả về món ăn...">{{ old('description', $meal->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Preparation --}}
                            {{-- <div class="mb-3">
                                <label for="preparation" class="form-label">Cách chế biến</label>
                                <textarea class="form-control" id="preparation" name="preparation" rows="6"
                                    placeholder="Hướng dẫn cách chế biến món ăn...">{{ old('preparation', $meal->preparation ?? '') }}</textarea>
                            </div> --}}
                        </div>
                    </div>

                    {{-- Tags Section với error styling --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2">Tags món ăn</h6>
                            @error('tags')
                                <div class="alert alert-danger py-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            @error('tags.*')
                                <div class="alert alert-danger py-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="row">
                                @foreach ($tags as $tag)
                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input @error('tags') is-invalid @enderror @error('tags.*') is-invalid @enderror"
                                                type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                                id="tag{{ $tag->id }}"
                                                {{ (isset($meal) && $meal->tags->contains($tag->id)) || (is_array(old('tags')) && in_array($tag->id, old('tags'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Allergens Section với error styling --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2">Chất gây dị ứng</h6>
                            @error('allergens')
                                <div class="alert alert-danger py-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            @error('allergens.*')
                                <div class="alert alert-danger py-2">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <div class="row">
                                @foreach ($allergens as $allergen)
                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input @error('allergens') is-invalid @enderror @error('allergens.*') is-invalid @enderror"
                                                type="checkbox" name="allergens[]" value="{{ $allergen->id }}"
                                                id="allergen{{ $allergen->id }}"
                                                {{ (isset($meal) && $meal->allergens->contains($allergen->id)) || (is_array(old('allergens')) && in_array($allergen->id, old('allergens'))) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="allergen{{ $allergen->id }}">
                                                {{ $allergen->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Recipe Ingredients Section --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <h6 class="mb-0">Nguyên liệu công thức</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                        onclick="toggleIngredientPanel()">
                                        <i class="bi bi-plus-circle"></i> Thêm nguyên liệu
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="clearAllIngredients()">
                                        <i class="bi bi-trash"></i> Xóa tất cả
                                    </button>
                                </div>
                            </div>

                            {{-- Ingredients Errors --}}
                            @error('ingredients')
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <strong>Lỗi nguyên liệu:</strong> {{ $message }}
                                </div>
                            @enderror
                            @if ($errors->has('ingredients.*'))
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <strong>Chi tiết lỗi nguyên liệu:</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->get('ingredients.*') as $field => $messages)
                                            @foreach ($messages as $message)
                                                <li>
                                                    @if (str_contains($field, 'ingredient_id'))
                                                        <strong>Nguyên liệu:</strong> {{ $message }}
                                                    @elseif (str_contains($field, 'quantity'))
                                                        <strong>Số lượng:</strong> {{ $message }}
                                                    @else
                                                        {{ $message }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                {{-- Ingredients Library Panel --}}
                                <div class="col-md-4" id="ingredients-panel" style="display: none;">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0"><i class="bi bi-basket"></i> Thư viện nguyên liệu</h6>
                                        </div>
                                        <div class="card-body">
                                            {{-- Search and Filter --}}
                                            <div class="mb-3">
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                                    <input type="text" class="form-control" id="ingredient-search"
                                                        placeholder="Tìm kiếm nguyên liệu...">
                                                </div>
                                                <select class="form-select form-select-sm" id="ingredient-filter">
                                                    <option value="">Tất cả loại</option>
                                                    <option value="protein">Nhiều Protein</option>
                                                    <option value="carb">Nhiều Carb</option>
                                                    <option value="fat">Nhiều Fat</option>
                                                    <option value="vegetable">Rau củ</option>
                                                    <option value="spice">Gia vị</option>
                                                </select>
                                            </div>

                                            {{-- Ingredients List --}}
                                            <div class="ingredients-list" style="max-height: 400px; overflow-y: auto;">
                                                @foreach ($ingredients as $ingredient)
                                                    <div class="ingredient-item mb-2 p-2 border rounded cursor-pointer"
                                                        draggable="true" data-id="{{ $ingredient->id }}"
                                                        data-name="{{ $ingredient->name }}"
                                                        data-unit="{{ $ingredient->unit }}"
                                                        data-protein="{{ $ingredient->protein }}"
                                                        data-carb="{{ $ingredient->carb }}"
                                                        data-fat="{{ $ingredient->fat }}"
                                                        data-calories="{{ $ingredient->calo }}">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong
                                                                    class="ingredient-name">{{ $ingredient->name }}</strong>
                                                                <small
                                                                    class="text-muted d-block">{{ $ingredient->unit }}</small>
                                                            </div>
                                                            <div class="text-end">
                                                                <small
                                                                    class="d-block text-primary">{{ $ingredient->calo }}
                                                                    kcal</small>
                                                                <small class="text-muted">P:{{ $ingredient->protein }}g
                                                                    C:{{ $ingredient->carb }}g
                                                                    F:{{ $ingredient->fat }}g</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="text-center mt-3">
                                                <small class="text-muted">
                                                    <i class="bi bi-info-circle"></i> Kéo thả hoặc double-click để thêm
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Recipe Drop Zone --}}
                                <div id="recipe-column" class="col-md-12">
                                    <div class="card border-primary" id="recipe-drop-zone" ondrop="drop(event)"
                                        ondragover="allowDrop(event)">
                                        <div class="card-header bg-primary text-white">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0"><i class="bi bi-list-ul"></i> Nguyên liệu trong công
                                                    thức</h6>
                                                <div class="nutrition-summary">
                                                    <small>
                                                        <span id="total-calories">0</span> kcal |
                                                        P: <span id="total-protein">0</span>g |
                                                        C: <span id="total-carb">0</span>g |
                                                        F: <span id="total-fat">0</span>g
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="min-height: 200px;">
                                            <div id="ingredients-container">
                                                @if (isset($meal) && $meal->recipeIngredients->count() > 0)
                                                    @foreach ($meal->recipeIngredients as $index => $recipeIngredient)
                                                        <div class="recipe-ingredient-row mb-3 p-3 border rounded bg-light"
                                                            data-index="{{ $index }}">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-5">
                                                                    <strong>{{ $recipeIngredient->ingredient->name }}</strong>
                                                                    <small
                                                                        class="text-muted d-block">{{ $recipeIngredient->ingredient->unit }}</small>
                                                                    <input type="hidden"
                                                                        name="ingredients[{{ $index }}][ingredient_id]"
                                                                        value="{{ $recipeIngredient->ingredient_id }}">
                                                                    <input type="hidden" class="base-protein"
                                                                        value="{{ $recipeIngredient->ingredient->protein }}">
                                                                    <input type="hidden" class="base-carb"
                                                                        value="{{ $recipeIngredient->ingredient->carb }}">
                                                                    <input type="hidden" class="base-fat"
                                                                        value="{{ $recipeIngredient->ingredient->fat }}">
                                                                    <input type="hidden" class="base-calories"
                                                                        value="{{ $recipeIngredient->ingredient->calo }}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="number"
                                                                        class="form-control quantity-input"
                                                                        name="ingredients[{{ $index }}][quantity]"
                                                                        value="{{ $recipeIngredient->quantity }}"
                                                                        placeholder="Số lượng" step="0.1"
                                                                        min="0"
                                                                        onchange="calculateNutrition(this)">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="nutrition-info">
                                                                        <small class="d-block">Calories: <span
                                                                                class="calories">{{ number_format(($recipeIngredient->ingredient->calo * $recipeIngredient->quantity) / 100, 0) }}</span>
                                                                            kcal</small>
                                                                        <small class="d-block">
                                                                            P: <span
                                                                                class="protein">{{ number_format(($recipeIngredient->ingredient->protein * $recipeIngredient->quantity) / 100, 1) }}</span>g
                                                                            |
                                                                            C: <span
                                                                                class="carb">{{ number_format(($recipeIngredient->ingredient->carb * $recipeIngredient->quantity) / 100, 1) }}</span>g
                                                                            |
                                                                            F: <span
                                                                                class="fat">{{ number_format(($recipeIngredient->ingredient->fat * $recipeIngredient->quantity) / 100, 1) }}</span>g
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-sm"
                                                                        onclick="removeRecipeIngredient(this)">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="empty-state text-center text-muted py-4">
                                                        <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                                                        <h6>Kéo thả nguyên liệu vào đây</h6>
                                                        <p class="mb-0">Hoặc click "Thêm nguyên liệu" để bắt đầu</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Preparation Section với error styling --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <h6 class="mb-0">Cách chế biến món ăn</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                        onclick="addPreparationStep()">
                                        <i class="bi bi-plus-circle"></i> Thêm bước
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="clearAllSteps()">
                                        <i class="bi bi-trash"></i> Xóa tất cả
                                    </button>
                                </div>
                            </div>

                            {{-- Preparation Errors --}}
                            @error('preparation')
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            @error('preparation_steps')
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            @if ($errors->has('preparation_steps.*'))
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    <strong>Lỗi bước chế biến:</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->get('preparation_steps.*') as $error)
                                            @foreach ($error as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div id="preparation-steps-container">
                                @if (isset($meal) && $meal->preparation)
                                    @php
                                        // Tách preparation thành các bước (split by line breaks)
                                        $steps = explode("\n", trim($meal->preparation));
                                        $steps = array_filter($steps, function ($step) {
                                            return trim($step) !== '';
                                        });
                                    @endphp

                                    @if (count($steps) > 0)
                                        @foreach ($steps as $index => $step)
                                            <div class="preparation-step mb-3 p-3 border rounded bg-light"
                                                data-step="{{ $index + 1 }}">
                                                <div class="row align-items-center">
                                                    <div class="col-md-1">
                                                        <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width: 35px; height: 35px;">
                                                            <strong>B{{ $index + 1 }}</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <textarea class="form-control step-content" name="preparation_steps[]" rows="2"
                                                            placeholder="Nhập bước chế biến...">{{ trim($step) }}</textarea>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="removePreparationStep(this)">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="empty-steps-state text-center text-muted py-4">
                                            <i class="bi bi-list-ol fs-1 d-block mb-2"></i>
                                            <h6>Chưa có bước chế biến nào</h6>
                                            <p class="mb-0">Click "Thêm bước" để bắt đầu</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="empty-steps-state text-center text-muted py-4">
                                        <i class="bi bi-list-ol fs-1 d-block mb-2"></i>
                                        <h6>Chưa có bước chế biến nào</h6>
                                        <p class="mb-0">Click "Thêm bước" để bắt đầu</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Hidden field để lưu preparation as text --}}
                            <textarea id="preparation" name="preparation" style="display: none;">{{ old('preparation', $meal->preparation ?? '') }}</textarea>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('meals.index') }}" class="btn btn-secondary me-md-2">Hủy</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>
                                    {{ isset($meal) && $meal ? 'Cập nhật món ăn' : 'Thêm món ăn' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simplified JavaScript - focus on UI interactions
        let ingredientIndex = {{ isset($meal) ? $meal->recipeIngredients->count() : 0 }};
        let stepIndex = {{ isset($meal) && $meal->preparation ? count(explode("\n", trim($meal->preparation))) : 0 }};

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing meal form...');

            initializeDragAndDrop();
            setTimeout(() => {
                initializeExistingIngredients();
                updateTotalNutrition();
            }, 100);

            // Remove client-side validation, let server handle it
            const form = document.getElementById('mealForm');
            form.addEventListener('submit', function(e) {
                // Just show loading message
                showAlert('Đang lưu món ăn...', 'info');

                // Update preparation field before submission
                updatePreparationField();

                // Let form submit naturally - no preventDefault
            });

            // Real-time error removal when user fixes input
            document.getElementById('name').addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('is-invalid');
                    removeFieldError('name');
                }
            });

            document.getElementById('meal_type_id').addEventListener('change', function() {
                if (this.value !== '') {
                    this.classList.remove('is-invalid');
                    removeFieldError('meal_type_id');
                }
            });

            document.getElementById('diet_type_id').addEventListener('change', function() {
                if (this.value !== '') {
                    this.classList.remove('is-invalid');
                    removeFieldError('diet_type_id');
                }
            });

            // Auto-resize existing textareas
            document.querySelectorAll('.step-content').forEach(textarea => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });

        // Helper function to remove field errors
        function removeFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.remove('is-invalid');
                const errorDiv = field.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.remove();
                }
            }
        }

        // Recipe ingredient management
        function initializeDragAndDrop() {
            // Add drag event listeners to all ingredient items
            document.querySelectorAll('.ingredient-item').forEach(item => {
                item.setAttribute('draggable', 'true');

                item.addEventListener('dragstart', function(e) {
                    this.style.opacity = '0.5';
                    this.classList.add('dragging');
                    e.dataTransfer.setData("ingredient-id", this.dataset.id);
                    e.dataTransfer.setData("ingredient-name", this.dataset.name);
                    e.dataTransfer.setData("ingredient-unit", this.dataset.unit);
                    e.dataTransfer.setData("ingredient-protein", this.dataset.protein);
                    e.dataTransfer.setData("ingredient-carb", this.dataset.carb);
                    e.dataTransfer.setData("ingredient-fat", this.dataset.fat);
                    e.dataTransfer.setData("ingredient-calories", this.dataset.calories);
                });

                item.addEventListener('dragend', function(e) {
                    this.style.opacity = '1';
                    this.classList.remove('dragging');
                });

                // Double click to add
                item.addEventListener('dblclick', function() {
                    const ingredientId = this.dataset.id;
                    if (isIngredientExists(ingredientId)) {
                        showAlert('Nguyên liệu này đã được thêm vào công thức!', 'warning');
                        return;
                    }

                    addRecipeIngredient(
                        this.dataset.id,
                        this.dataset.name,
                        this.dataset.unit,
                        this.dataset.protein,
                        this.dataset.carb,
                        this.dataset.fat,
                        this.dataset.calories
                    );
                });

                // Hover effects
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#e3f2fd';
                    this.style.transform = 'scale(1.02)';
                    this.style.transition = 'all 0.2s';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                    this.style.transform = 'scale(1)';
                });
            });
        }

        function initializeExistingIngredients() {
            // Calculate nutrition for existing ingredients
            document.querySelectorAll('.recipe-ingredient-row').forEach(row => {
                const quantityInput = row.querySelector('.quantity-input');
                if (quantityInput && quantityInput.value) {
                    // Đảm bảo có base nutrition data
                    const hasBaseData = row.querySelector('.base-protein') &&
                        row.querySelector('.base-carb') &&
                        row.querySelector('.base-fat') &&
                        row.querySelector('.base-calories');

                    if (hasBaseData) {
                        calculateNutrition(quantityInput);
                    } else {
                        console.warn('Missing base nutrition data for ingredient row');
                    }
                }
            });
        }

        // Toggle ingredient panel
        function toggleIngredientPanel() {
            const panel = document.getElementById('ingredients-panel');
            const recipeColumn = document.getElementById('recipe-column');

            if (panel.style.display === 'none' || panel.style.display === '') {
                panel.style.display = 'block';
                recipeColumn.className = 'col-md-8';
                // Focus on search input
                setTimeout(() => {
                    document.getElementById('ingredient-search').focus();
                }, 100);
            } else {
                panel.style.display = 'none';
                recipeColumn.className = 'col-md-12';
            }
        }

        // Search ingredients
        document.getElementById('ingredient-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const filter = document.getElementById('ingredient-filter').value;
            filterIngredients(searchTerm, filter);
        });

        // Filter ingredients by type
        document.getElementById('ingredient-filter').addEventListener('change', function() {
            const searchTerm = document.getElementById('ingredient-search').value.toLowerCase();
            const filter = this.value;
            filterIngredients(searchTerm, filter);
        });

        function filterIngredients(searchTerm, filter) {
            const ingredients = document.querySelectorAll('.ingredient-item');
            let visibleCount = 0;

            ingredients.forEach(item => {
                const name = item.querySelector('.ingredient-name').textContent.toLowerCase();
                const protein = parseFloat(item.dataset.protein);
                const carb = parseFloat(item.dataset.carb);
                const fat = parseFloat(item.dataset.fat);

                let matchesSearch = name.includes(searchTerm);
                let matchesFilter = true;

                if (filter) {
                    switch (filter) {
                        case 'protein':
                            matchesFilter = protein > carb && protein > fat;
                            break;
                        case 'carb':
                            matchesFilter = carb > protein && carb > fat;
                            break;
                        case 'fat':
                            matchesFilter = fat > protein && fat > carb;
                            break;
                        case 'vegetable':
                            matchesFilter = name.includes('rau') || name.includes('củ') || name.includes('lá') ||
                                name.includes('cà') || name.includes('nấm');
                            break;
                        case 'spice':
                            matchesFilter = name.includes('muối') || name.includes('tiêu') || name.includes(
                                    'gia vị') ||
                                name.includes('hành') || name.includes('tỏi') || name.includes('gừng');
                            break;
                    }
                }

                const shouldShow = matchesSearch && matchesFilter;
                item.style.display = shouldShow ? 'block' : 'none';
                if (shouldShow) visibleCount++;
            });

            // Show no results message
            const existingNoResults = document.querySelector('.no-results-message');
            if (existingNoResults) existingNoResults.remove();

            if (visibleCount === 0) {
                const noResultsMessage = document.createElement('div');
                noResultsMessage.className = 'no-results-message text-center text-muted py-3';
                noResultsMessage.innerHTML = `
                <i class="bi bi-search fs-3 d-block mb-2"></i>
                <p class="mb-0">Không tìm thấy nguyên liệu nào</p>
            `;
                document.querySelector('.ingredients-list').appendChild(noResultsMessage);
            }
        }

        // Drag and Drop functionality
        function allowDrop(ev) {
            ev.preventDefault();
            const dropZone = ev.currentTarget;
            dropZone.style.borderColor = '#007bff';
            dropZone.querySelector('.card-body').style.backgroundColor = '#f0f8ff';
        }

        function drop(ev) {
            ev.preventDefault();
            const dropZone = ev.currentTarget;
            dropZone.style.borderColor = '';
            dropZone.querySelector('.card-body').style.backgroundColor = '';

            const ingredientId = ev.dataTransfer.getData("ingredient-id");
            const ingredientName = ev.dataTransfer.getData("ingredient-name");
            const ingredientUnit = ev.dataTransfer.getData("ingredient-unit");
            const ingredientProtein = ev.dataTransfer.getData("ingredient-protein");
            const ingredientCarb = ev.dataTransfer.getData("ingredient-carb");
            const ingredientFat = ev.dataTransfer.getData("ingredient-fat");
            const ingredientCalories = ev.dataTransfer.getData("ingredient-calories");

            // Check if ingredient already exists
            if (isIngredientExists(ingredientId)) {
                showAlert('Nguyên liệu này đã được thêm vào công thức!', 'warning');
                return;
            }

            addRecipeIngredient(ingredientId, ingredientName, ingredientUnit, ingredientProtein, ingredientCarb,
                ingredientFat, ingredientCalories);
            showAlert(`Đã thêm ${ingredientName} vào công thức!`, 'success');
        }

        function isIngredientExists(ingredientId) {
            return document.querySelector(`input[name*="[ingredient_id]"][value="${ingredientId}"]`) !== null;
        }

        function addRecipeIngredient(id, name, unit, protein, carb, fat, calories) {
            const container = document.getElementById('ingredients-container');

            // Remove empty state if exists
            const emptyState = container.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            const ingredientRow = document.createElement('div');
            ingredientRow.className = 'recipe-ingredient-row mb-3 p-3 border rounded bg-light';
            ingredientRow.dataset.index = ingredientIndex;
            ingredientRow.innerHTML = `
            <div class="row align-items-center">
                <div class="col-md-5">
                    <strong>${name}</strong>
                    <small class="text-muted d-block">${unit}</small>
                    <input type="hidden" name="ingredients[${ingredientIndex}][ingredient_id]" value="${id}">
                    <input type="hidden" class="base-protein" value="${protein}">
                    <input type="hidden" class="base-carb" value="${carb}">
                    <input type="hidden" class="base-fat" value="${fat}">
                    <input type="hidden" class="base-calories" value="${calories}">
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control quantity-input" 
                           name="ingredients[${ingredientIndex}][quantity]"
                           value="100" 
                           placeholder="Số lượng" step="0.1" min="0"
                           onchange="calculateNutrition(this)">
                </div>
                <div class="col-md-3">
                    <div class="nutrition-info">
                        <small class="d-block">Calories: <span class="calories">${calories}</span> kcal</small>
                        <small class="d-block">P: <span class="protein">${protein}</span>g | C: <span class="carb">${carb}</span>g | F: <span class="fat">${fat}</span>g</small>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRecipeIngredient(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;

            container.appendChild(ingredientRow);
            ingredientIndex++;

            // Calculate nutrition for initial quantity
            const quantityInput = ingredientRow.querySelector('.quantity-input');
            calculateNutrition(quantityInput);

            // Update total nutrition
            updateTotalNutrition();

            // Add animation
            ingredientRow.style.opacity = '0';
            ingredientRow.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                ingredientRow.style.transition = 'all 0.3s ease';
                ingredientRow.style.opacity = '1';
                ingredientRow.style.transform = 'translateY(0)';
            }, 50);
        }

        function removeRecipeIngredient(button) {
            const row = button.closest('.recipe-ingredient-row');

            // Add remove animation
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(100px)';

            setTimeout(() => {
                row.remove();

                // Show empty state if no ingredients left
                const container = document.getElementById('ingredients-container');
                if (container.querySelectorAll('.recipe-ingredient-row').length === 0) {
                    container.innerHTML = `
                    <div class="empty-state text-center text-muted py-4">
                        <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                        <h6>Kéo thả nguyên liệu vào đây</h6>
                        <p class="mb-0">Hoặc click "Thêm nguyên liệu" để bắt đầu</p>
                    </div>
                `;
                }

                updateTotalNutrition();
            }, 300);
        }

        function calculateNutrition(quantityInput) {
            const row = quantityInput.closest('.recipe-ingredient-row');
            const quantity = parseFloat(quantityInput.value) || 0;

            const baseProtein = parseFloat(row.querySelector('.base-protein')?.value || 0);
            const baseCarb = parseFloat(row.querySelector('.base-carb')?.value || 0);
            const baseFat = parseFloat(row.querySelector('.base-fat')?.value || 0);
            const baseCalories = parseFloat(row.querySelector('.base-calories')?.value || 0);

            // Calculate nutrition based on quantity (per 100g base)
            const actualProtein = (baseProtein * quantity / 100).toFixed(1);
            const actualCarb = (baseCarb * quantity / 100).toFixed(1);
            const actualFat = (baseFat * quantity / 100).toFixed(1);
            const actualCalories = (baseCalories * quantity / 100).toFixed(0);

            // Update display
            const proteinSpan = row.querySelector('.protein');
            const carbSpan = row.querySelector('.carb');
            const fatSpan = row.querySelector('.fat');
            const caloriesSpan = row.querySelector('.calories');

            if (proteinSpan) proteinSpan.textContent = actualProtein;
            if (carbSpan) carbSpan.textContent = actualCarb;
            if (fatSpan) fatSpan.textContent = actualFat;
            if (caloriesSpan) caloriesSpan.textContent = actualCalories;

            updateTotalNutrition();
        }

        function updateTotalNutrition() {
            let totalProtein = 0;
            let totalCarb = 0;
            let totalFat = 0;
            let totalCalories = 0;

            document.querySelectorAll('.recipe-ingredient-row').forEach(row => {
                const proteinElement = row.querySelector('.protein');
                const carbElement = row.querySelector('.carb');
                const fatElement = row.querySelector('.fat');
                const caloriesElement = row.querySelector('.calories');

                if (proteinElement) totalProtein += parseFloat(proteinElement.textContent) || 0;
                if (carbElement) totalCarb += parseFloat(carbElement.textContent) || 0;
                if (fatElement) totalFat += parseFloat(fatElement.textContent) || 0;
                if (caloriesElement) totalCalories += parseFloat(caloriesElement.textContent) || 0;
            });

            // Update display with animation
            updateCounterWithAnimation('total-protein', totalProtein.toFixed(1));
            updateCounterWithAnimation('total-carb', totalCarb.toFixed(1));
            updateCounterWithAnimation('total-fat', totalFat.toFixed(1));
            updateCounterWithAnimation('total-calories', totalCalories.toFixed(0));
        }

        function updateCounterWithAnimation(elementId, newValue) {
            const element = document.getElementById(elementId);
            if (element) {
                element.style.transition = 'all 0.3s ease';
                element.style.color = '#007bff';
                element.textContent = newValue;
                setTimeout(() => {
                    element.style.color = '';
                }, 300);
            }
        }

        function clearAllIngredients() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả nguyên liệu?')) {
                const container = document.getElementById('ingredients-container');
                container.innerHTML = `
                <div class="empty-state text-center text-muted py-4">
                    <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                    <h6>Kéo thả nguyên liệu vào đây</h6>
                    <p class="mb-0">Hoặc click "Thêm nguyên liệu" để bắt đầu</p>
                </div>
            `;
                updateTotalNutrition();
                ingredientIndex = 0;
                showAlert('Đã xóa tất cả nguyên liệu!', 'info');
            }
        }

        function showAlert(message, type = 'info') {
            // Remove existing alerts
            const existingAlert = document.querySelector('.floating-alert');
            if (existingAlert) existingAlert.remove();

            // Create new alert
            const alert = document.createElement('div');
            alert.className = `floating-alert alert alert-${type} alert-dismissible fade show position-fixed`;
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
        `;

            document.body.appendChild(alert);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (alert.parentElement) alert.remove();
            }, 3000);
        }

        // Image preview function
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        // Thêm function debug để kiểm tra data
        function debugIngredientData() {
            console.log('=== Debug Ingredient Data ===');
            document.querySelectorAll('.recipe-ingredient-row').forEach((row, index) => {
                const quantity = row.querySelector('.quantity-input')?.value;
                const baseProtein = row.querySelector('.base-protein')?.value;
                const baseCarb = row.querySelector('.base-carb')?.value;
                const baseFat = row.querySelector('.base-fat')?.value;
                const baseCalories = row.querySelector('.base-calories')?.value;

                console.log(`Row ${index}:`, {
                    quantity,
                    baseProtein,
                    baseCarb,
                    baseFat,
                    baseCalories
                });
            });
        }

        // Preparation Steps Management

        function addPreparationStep() {
            const container = document.getElementById('preparation-steps-container');

            // Remove empty state if exists
            const emptyState = container.querySelector('.empty-steps-state');
            if (emptyState) {
                emptyState.remove();
            }

            stepIndex++;

            const stepDiv = document.createElement('div');
            stepDiv.className = 'preparation-step mb-3 p-3 border rounded bg-light';
            stepDiv.dataset.step = stepIndex;
            stepDiv.innerHTML = `
        <div class="row align-items-center">
            <div class="col-md-1">
                <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                    <strong>B${stepIndex}</strong>
                </div>
            </div>
            <div class="col-md-10">
                <textarea class="form-control step-content" name="preparation_steps[]" rows="2" placeholder="Nhập bước chế biến..."></textarea>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removePreparationStep(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

            container.appendChild(stepDiv);

            // Add animation
            stepDiv.style.opacity = '0';
            stepDiv.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                stepDiv.style.transition = 'all 0.3s ease';
                stepDiv.style.opacity = '1';
                stepDiv.style.transform = 'translateY(0)';
            }, 50);

            // Focus on the new textarea
            setTimeout(() => {
                stepDiv.querySelector('.step-content').focus();
            }, 100);

            updatePreparationField();
            showAlert('Đã thêm bước chế biến mới!', 'success');
        }

        function removePreparationStep(button) {
            const step = button.closest('.preparation-step');

            // Add remove animation
            step.style.transition = 'all 0.3s ease';
            step.style.opacity = '0';
            step.style.transform = 'translateX(100px)';

            setTimeout(() => {
                step.remove();

                // Renumber all steps
                renumberPreparationSteps();

                // Show empty state if no steps left
                const container = document.getElementById('preparation-steps-container');
                if (container.querySelectorAll('.preparation-step').length === 0) {
                    container.innerHTML = `
                <div class="empty-steps-state text-center text-muted py-4">
                    <i class="bi bi-list-ol fs-1 d-block mb-2"></i>
                    <h6>Chưa có bước chế biến nào</h6>
                    <p class="mb-0">Click "Thêm bước" để bắt đầu</p>
                </div>
            `;
                    stepIndex = 0;
                }

                updatePreparationField();
            }, 300);
        }

        function renumberPreparationSteps() {
            const steps = document.querySelectorAll('.preparation-step');
            steps.forEach((step, index) => {
                const stepNumber = index + 1;
                step.dataset.step = stepNumber;
                step.querySelector('.step-number strong').textContent = `B${stepNumber}`;
            });
            stepIndex = steps.length;
        }

        function clearAllSteps() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả các bước chế biến?')) {
                const container = document.getElementById('preparation-steps-container');
                container.innerHTML = `
            <div class="empty-steps-state text-center text-muted py-4">
                <i class="bi bi-list-ol fs-1 d-block mb-2"></i>
                <h6>Chưa có bước chế biến nào</h6>
                <p class="mb-0">Click "Thêm bước" để bắt đầu</p>
            </div>
        `;
                stepIndex = 0;
                updatePreparationField();
                showAlert('Đã xóa tất cả các bước chế biến!', 'info');
            }
        }

        function updatePreparationField() {
            const steps = document.querySelectorAll('.step-content');
            const preparationText = Array.from(steps).map(step => step.value.trim()).filter(text => text !== '').join('\n');
            document.getElementById('preparation').value = preparationText;
        }

        // Add event listeners for step content changes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('step-content')) {
                updatePreparationField();
            }
        });

        // Auto-resize textareas
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('step-content')) {
                e.target.style.height = 'auto';
                e.target.style.height = e.target.scrollHeight + 'px';
            }
        });

        // Initialize existing steps on page load
        document.addEventListener('DOMContentLoaded', function() {
            // ... existing initialization code ...

            // Auto-resize existing textareas
            document.querySelectorAll('.step-content').forEach(textarea => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });
    </script>
@endsection
