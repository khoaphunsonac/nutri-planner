<div class="row g-3">
    {{-- Basic Info Row --}}
    <div class="col-md-8">
        <label for="name" class="form-label fw-medium">
            Tên nguyên liệu <span class="text-danger">*</span>
        </label>
        <input type="text" name="name" id="name" class="form-control form-control-sm"
            value="{{ old('name', $ingredient->name ?? '') }}" placeholder="Nhập tên nguyên liệu" required>
    </div>
    <div class="col-md-4">
        <label for="unit" class="form-label fw-medium">Đơn vị</label>
        <input type="text" name="unit" id="unit" class="form-control form-control-sm"
            value="{{ old('unit', $ingredient->unit ?? 'g') }}" placeholder="g, ml, kg...">
    </div>

    {{-- Nutrition Info Row --}}
    <div class="col-12">
        <div class="alert alert-info py-2">
            <small><i class="bi bi-info-circle me-1"></i>Nhập giá trị dinh dưỡng cho 100g/100ml nguyên liệu</small>
        </div>
    </div>

    <div class="col-md-3">
        <label for="protein" class="form-label fw-medium">
            <i class="bi bi-lightning text-warning me-1"></i>Protein (g)
        </label>
        <input type="number" name="protein" id="protein" step="0.1" min="0" max="100"
            class="form-control form-control-sm" value="{{ old('protein', $ingredient->protein ?? 0) }}"
            placeholder="0.0">
    </div>
    <div class="col-md-3">
        <label for="carb" class="form-label fw-medium">
            <i class="bi bi-lightning text-success me-1"></i>Carb (g)
        </label>
        <input type="number" name="carb" id="carb" step="0.1" min="0" max="100"
            class="form-control form-control-sm" value="{{ old('carb', $ingredient->carb ?? 0) }}" placeholder="0.0">
    </div>
    <div class="col-md-3">
        <label for="fat" class="form-label fw-medium">
            <i class="bi bi-lightning text-danger me-1"></i>Fat (g)
        </label>
        <input type="number" name="fat" id="fat" step="0.1" min="0" max="100"
            class="form-control form-control-sm" value="{{ old('fat', $ingredient->fat ?? 0) }}" placeholder="0.0">
    </div>
    <div class="col-md-3">
        <label class="form-label fw-medium">
            <i class="bi bi-calculator text-primary me-1"></i>Calo
        </label>
        <div class="input-group input-group-sm">
            <input type="text" class="form-control bg-light fw-bold text-primary" id="calo" readonly
                placeholder="0">
            <span class="input-group-text bg-primary text-white small">kcal</span>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="col-12">
        <hr class="my-3">
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('ingredients.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-x me-1"></i>Hủy
            </a>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-check me-1"></i>Lưu
            </button>
        </div>
    </div>
</div>

<script>
    function calculateCalories() {
        const protein = parseFloat(document.getElementById('protein').value) || 0;
        const carb = parseFloat(document.getElementById('carb').value) || 0;
        const fat = parseFloat(document.getElementById('fat').value) || 0;

        const calo = (protein * 4) + (carb * 4) + (fat * 9);
        document.getElementById('calo').value = Math.round(calo);
    }

    // Event listeners
    ['protein', 'carb', 'fat'].forEach(id => {
        const input = document.getElementById(id);
        input.addEventListener('input', calculateCalories);
        input.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            if (value < 0) this.value = 0;
            if (value > 100) this.value = 100;
        });
    });

    // Calculate on load
    document.addEventListener('DOMContentLoaded', calculateCalories);
</script>
