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
                <li class="breadcrumb-item active">
                    {{ isset($ingredient) && $ingredient ? 'Sửa: ' . $ingredient->name : 'Thêm mới' }}
                </li>
            </ol>
        </nav>

        {{-- Compact Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                {{ isset($ingredient) && $ingredient ? 'Cập nhật nguyên liệu' : 'Thêm nguyên liệu mới' }}
            </h4>
            <a href="{{ route('ingredients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Quay lại
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Có lỗi:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach ($errors->all() as $error)
                        <li><small>{{ $error }}</small></li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close pb-1" data-bs-dismiss="alert" style="font-size: 0.7rem;"></button>
            </div>
        @endif

        {{-- Compact Form --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('ingredients.save') }}">
                    @csrf
                    @if (isset($ingredient) && $ingredient)
                        <input type="hidden" name="id" value="{{ $ingredient->id }}">
                    @endif

                    <div class="row g-3">
                        {{-- Basic Info Row --}}
                        <div class="col-md-8">
                            <label for="name" class="form-label fw-medium">
                                Tên nguyên liệu <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm"
                                value="{{ old('name', $ingredient->name ?? '') }}" placeholder="Nhập tên nguyên liệu"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label for="unit" class="form-label fw-medium">
                                Đơn vị <span class="text-danger">*</span>
                            </label>
                            <select name="unit" id="unit" class="form-select form-select-sm" required>
                                <option value="">-- Chọn đơn vị --</option>
                                @foreach ($unitOptions as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('unit', $ingredient->unit ?? 'g') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nutrition Info Row --}}
                        <div class="col-12">
                            <div class="alert alert-info py-2">
                                <small><i class="bi bi-info-circle me-1"></i>Nhập giá trị dinh dưỡng cho 100g/100ml nguyên
                                    liệu</small>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="protein" class="form-label fw-medium">
                                <i class="bi bi-lightning text-warning me-1"></i>Protein (g)
                            </label>
                            <input type="number" name="protein" id="protein" step="0.1" min="0" max="100"
                                class="form-control form-control-sm"
                                value="{{ old('protein', $ingredient->protein ?? 0) }}" placeholder="0.0">
                        </div>

                        <div class="col-md-3">
                            <label for="carb" class="form-label fw-medium">
                                <i class="bi bi-lightning text-success me-1"></i>Carbohydrate (g)
                            </label>
                            <input type="number" name="carb" id="carb" step="0.1" min="0" max="100"
                                class="form-control form-control-sm" value="{{ old('carb', $ingredient->carb ?? 0) }}"
                                placeholder="0.0">
                        </div>

                        <div class="col-md-3">
                            <label for="fat" class="form-label fw-medium">
                                <i class="bi bi-lightning text-danger me-1"></i>Chất béo (g)
                            </label>
                            <input type="number" name="fat" id="fat" step="0.1" min="0" max="100"
                                class="form-control form-control-sm" value="{{ old('fat', $ingredient->fat ?? 0) }}"
                                placeholder="0.0">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-medium">
                                <i class="bi bi-fire text-primary me-1"></i>Calo (tự tính)
                            </label>
                            <input type="text" id="calculated-calo" class="form-control form-control-sm bg-light"
                                value="0" readonly placeholder="Tự động tính">
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-12">
                            <hr class="my-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-check me-1"></i>
                                    {{ isset($ingredient) && $ingredient ? 'Cập nhật' : 'Thêm mới' }}
                                </button>
                                <a href="{{ route('ingredients.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="bi bi-x me-1"></i>Hủy
                                </a>
                                @if (isset($ingredient) && $ingredient)
                                    <a href="{{ route('ingredients.show', $ingredient->id) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="bi bi-eye me-1"></i>Xem chi tiết
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const proteinInput = document.getElementById('protein');
            const carbInput = document.getElementById('carb');
            const fatInput = document.getElementById('fat');
            const caloDisplay = document.getElementById('calculated-calo');

            function calculateCalo() {
                const protein = parseFloat(proteinInput.value) || 0;
                const carb = parseFloat(carbInput.value) || 0;
                const fat = parseFloat(fatInput.value) || 0;

                const totalCalo = (protein * 4) + (carb * 4) + (fat * 9);
                caloDisplay.value = Math.round(totalCalo * 100) / 100;
            }

            // Calculate calo on input change
            [proteinInput, carbInput, fatInput].forEach(input => {
                input.addEventListener('input', calculateCalo);
            });

            // Initial calculation
            calculateCalo();
        });
    </script>
@endsection
