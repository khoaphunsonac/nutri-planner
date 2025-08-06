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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                            {{-- Meal Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên món ăn <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $meal->name ?? '') }}" required>
                            </div>

                            {{-- Meal Type --}}
                            <div class="mb-3">
                                <label for="meal_type_id" class="form-label">Loại bữa ăn <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="meal_type_id" name="meal_type_id" required>
                                    <option value="">Chọn loại bữa ăn</option>
                                    @foreach ($mealTypes as $mealType)
                                        <option value="{{ $mealType->id }}"
                                            {{ old('meal_type_id', $meal->meal_type_id ?? '') == $mealType->id ? 'selected' : '' }}>
                                            {{ $mealType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Diet Type --}}
                            <div class="mb-3">
                                <label for="diet_type_id" class="form-label">Chế độ ăn <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="diet_type_id" name="diet_type_id" required>
                                    <option value="">Chọn chế độ ăn</option>
                                    @foreach ($dietTypes as $dietType)
                                        <option value="{{ $dietType->id }}"
                                            {{ old('diet_type_id', $meal->diet_type_id ?? '') == $dietType->id ? 'selected' : '' }}>
                                            {{ $dietType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Image Upload --}}
                            <div class="mb-3">
                                <label for="image" class="form-label">Hình ảnh món ăn</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                    onchange="previewImage(this)">
                                <div class="form-text">Chọn file hình ảnh (JPG, PNG, GIF) - Tối đa 2MB</div>

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
                            {{-- Description --}}
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Mô tả về món ăn...">{{ old('description', $meal->description ?? '') }}</textarea>
                            </div>

                            {{-- Preparation --}}
                            <div class="mb-3">
                                <label for="preparation" class="form-label">Cách chế biến</label>
                                <textarea class="form-control" id="preparation" name="preparation" rows="6"
                                    placeholder="Hướng dẫn cách chế biến món ăn...">{{ old('preparation', $meal->preparation ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Tags Section --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2">Tags món ăn</h6>
                            <div class="row">
                                @foreach ($tags as $tag)
                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tags[]"
                                                value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                                {{ isset($meal) && $meal->tags->contains($tag->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Allergens Section --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2">Chất gây dị ứng</h6>
                            <div class="row">
                                @foreach ($allergens as $allergen)
                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allergens[]"
                                                value="{{ $allergen->id }}" id="allergen{{ $allergen->id }}"
                                                {{ isset($meal) && $meal->allergens->contains($allergen->id) ? 'checked' : '' }}>
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
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addIngredient()">
                                    <i class="bi bi-plus"></i> Thêm nguyên liệu
                                </button>
                            </div>

                            <div id="ingredients-container">
                                @if (isset($meal) && $meal->recipeIngredients->count() > 0)
                                    @foreach ($meal->recipeIngredients as $index => $recipeIngredient)
                                        <div class="ingredient-row row mb-2" data-index="{{ $index }}">
                                            <div class="col-md-6">
                                                <select class="form-select ingredient-select"
                                                    name="ingredients[{{ $index }}][ingredient_id]">
                                                    <option value="">Chọn nguyên liệu</option>
                                                    @foreach ($ingredients as $ingredient)
                                                        <option value="{{ $ingredient->id }}"
                                                            {{ $recipeIngredient->ingredient_id == $ingredient->id ? 'selected' : '' }}>
                                                            {{ $ingredient->name }} ({{ $ingredient->unit }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" class="form-control quantity-input"
                                                    name="ingredients[{{ $index }}][quantity]"
                                                    value="{{ $recipeIngredient->quantity }}" placeholder="Số lượng"
                                                    step="0.1" min="0">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                                    onclick="removeIngredient(this)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted text-center py-3">
                                        <i class="bi bi-basket3 fs-3 d-block mb-2"></i>
                                        <p class="mb-0">Chưa có nguyên liệu nào. Click "Thêm nguyên liệu" để bắt đầu.</p>
                                    </div>
                                @endif
                            </div>
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
        let ingredientIndex = {{ isset($meal) ? $meal->recipeIngredients->count() : 0 }};

        function addIngredient() {
            const container = document.getElementById('ingredients-container');

            // Remove empty message if exists
            const emptyMessage = container.querySelector('.text-muted.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            const ingredientRow = `
                <div class="ingredient-row row mb-2" data-index="${ingredientIndex}">
                    <div class="col-md-6">
                        <select class="form-select ingredient-select" name="ingredients[${ingredientIndex}][ingredient_id]">
                            <option value="">Chọn nguyên liệu</option>
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }} ({{ $ingredient->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control quantity-input" 
                            name="ingredients[${ingredientIndex}][quantity]" 
                            placeholder="Số lượng" step="0.1" min="0">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100" 
                            onclick="removeIngredient(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', ingredientRow);
            ingredientIndex++;
        }

        function removeIngredient(button) {
            const row = button.closest('.ingredient-row');
            row.remove();

            // Show empty message if no ingredients left
            const container = document.getElementById('ingredients-container');
            if (container.querySelectorAll('.ingredient-row').length === 0) {
                container.innerHTML = `
                    <div class="text-muted text-center py-3">
                        <i class="bi bi-basket3 fs-3 d-block mb-2"></i>
                        <p class="mb-0">Chưa có nguyên liệu nào. Click "Thêm nguyên liệu" để bắt đầu.</p>
                    </div>
                `;
            }
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

        // Form validation
        document.getElementById('mealForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const mealType = document.getElementById('meal_type_id').value;
            const dietType = document.getElementById('diet_type_id').value;

            if (!name || !mealType || !dietType) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
            }
        });
    </script>
@endsection
