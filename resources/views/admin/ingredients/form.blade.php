<div class="ingredients-form">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">
                    <i class="bi bi-tag me-1"></i>Tên nguyên liệu <span class="text-danger">*</span>
                </label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $ingredient->name ?? '') }}" placeholder="Nhập tên nguyên liệu..." required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="unit" class="form-label">
                    <i class="bi bi-rulers me-1"></i>Đơn vị tính
                </label>
                <input type="text" name="unit" id="unit" class="form-control"
                    value="{{ old('unit', $ingredient->unit ?? '') }}" placeholder="g, ml, kg, lít...">
            </div>
        </div>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Lưu ý:</strong> Nhập giá trị dinh dưỡng cho 100g/100ml nguyên liệu
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label for="protein" class="form-label">
                    <i class="bi bi-lightning me-1 text-warning"></i>Protein (g/100g)
                </label>
                <div class="input-group">
                    <input type="number" name="protein" id="protein" step="0.1" min="0"
                        class="form-control" value="{{ old('protein', $ingredient->protein ?? 0) }}" placeholder="0.0">
                    <span class="input-group-text">g</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="carb" class="form-label">
                    <i class="bi bi-lightning me-1 text-success"></i>Carbohydrate (g/100g)
                </label>
                <div class="input-group">
                    <input type="number" name="carb" id="carb" step="0.1" min="0"
                        class="form-control" value="{{ old('carb', $ingredient->carb ?? 0) }}" placeholder="0.0">
                    <span class="input-group-text">g</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label for="fat" class="form-label">
                    <i class="bi bi-lightning me-1 text-danger"></i>Chất béo (g/100g)
                </label>
                <div class="input-group">
                    <input type="number" name="fat" id="fat" step="0.1" min="0"
                        class="form-control" value="{{ old('fat', $ingredient->fat ?? 0) }}" placeholder="0.0">
                    <span class="input-group-text">g</span>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label">
            <i class="bi bi-calculator me-1 text-primary"></i>Tổng Calo (tự động tính)
        </label>
        <div class="input-group">
            <input type="text" class="form-control bg-light fw-bold text-primary" id="calo" readonly
                placeholder="0.00">
            <span class="input-group-text bg-primary text-white">kcal</span>
        </div>
        <div class="form-text">
            <small><i class="bi bi-info-circle"></i> Công thức: (Protein × 4) + (Carb × 4) + (Fat × 9)</small>
        </div>
    </div>

    <div class="d-flex gap-2 justify-content-end">
        <a href="{{ route('ingredients.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Quay lại
        </a>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-1"></i>Lưu thông tin
        </button>
    </div>

    <script>
        function calculateCalories() {
            const protein = parseFloat(document.getElementById('protein').value) || 0;
            const carb = parseFloat(document.getElementById('carb').value) || 0;
            const fat = parseFloat(document.getElementById('fat').value) || 0;

            const calo = (protein * 4) + (carb * 4) + (fat * 9);
            document.getElementById('calo').value = calo.toFixed(2);
        }

        // Add event listeners
        document.getElementById('protein').addEventListener('input', calculateCalories);
        document.getElementById('carb').addEventListener('input', calculateCalories);
        document.getElementById('fat').addEventListener('input', calculateCalories);

        // Calculate on page load
        window.addEventListener('DOMContentLoaded', calculateCalories);

        // Add input validation
        function validateInput(input) {
            const value = parseFloat(input.value);
            if (value < 0) {
                input.value = 0;
            }
            if (value > 100) {
                input.value = 100;
            }
        }

        document.getElementById('protein').addEventListener('blur', function() {
            validateInput(this);
        });
        document.getElementById('carb').addEventListener('blur', function() {
            validateInput(this);
        });
        document.getElementById('fat').addEventListener('blur', function() {
            validateInput(this);
        });
    </script>
</div>
