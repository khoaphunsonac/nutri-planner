@extends('site.layout')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Nutrition Calculator</h2>

    <!-- Search & Filter -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" id="ingredient-search" class="form-control" placeholder="Tìm nguyên liệu...">
        </div>
        <div class="col-md-3">
            <select id="ingredient-filter" class="form-control">
                <option value="">Tất cả</option>
                <option value="protein">Giàu Protein</option>
                <option value="carb">Giàu Carb</option>
                <option value="fat">Giàu Fat</option>
            </select>
        </div>
    </div>

    <div class="row">
        <!-- Ingredient List -->
        <div class="col-md-6">
            <h5>Danh sách nguyên liệu</h5>
            <div id="ingredients-list" class="border p-3" style="max-height:400px; overflow-y:auto;">
                <!-- Render từ JS -->
            </div>
        </div>

        <!-- Recipe Drop Zone -->
        <div class="col-md-6">
            <h5>Công thức của bạn</h5>
            <div id="recipe-dropzone" class="border p-3 mb-3" style="min-height:200px;">
                <div class="text-muted">Kéo thả nguyên liệu vào đây</div>
            </div>

            <!-- Totals -->
            <div class="border p-3">
                <h6>Tổng dinh dưỡng</h6>
                <p>Protein: <span id="total-protein">0</span> g</p>
                <p>Carb: <span id="total-carb">0</span> g</p>
                <p>Fat: <span id="total-fat">0</span> g</p>
                <p>Calories: <span id="total-calories">0</span> kcal</p>
                <button id="export-excel" class="btn btn-success mt-2">Xuất Excel</button>
            </div>
        </div>
    </div>
</div>

<script>
    const ingredients = @json($ingredientsJson);
</script>

<script src="{{ asset('assets/user/js/nutri-calc.js') }}"></script>
@endsection
