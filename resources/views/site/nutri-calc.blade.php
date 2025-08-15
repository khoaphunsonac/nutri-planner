@extends('site.layout')

@section('content')
    <style>
        /* Color Variables */
        :root {
            --dark: #343941;
            --muted: #6C757D;
            --light: #ADB5BD;
            --accent: #E83850;
            --accent2: #17A2B8;
            --white: #ffffff;
            --gray-50: #f8f9fa;
            --gray-100: #f1f3f4;
            --gray-200: #e9ecef;
            --shadow-sm: 0 2px 4px rgba(52, 57, 65, 0.1);
            --shadow-md: 0 4px 8px rgba(52, 57, 65, 0.15);
            --border-radius: 12px;
            --transition: all 0.2s ease;
        }

        /* Background */
        body {
            background-color: var(--gray-50);
        }

        /* Header */
        .page-header {
            background-color: var(--dark);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        /* Modern Cards */
        .modern-card {
            background-color: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .modern-card.recipe-card {
            border-top: 4px solid var(--accent);
        }

        .modern-card:not(.recipe-card) {
            border-top: 4px solid var(--accent2);
        }

        /* Card Headers */
        .card-header-modern {
            background-color: var(--dark);
            border: none;
            padding: 1.5rem;
        }

        .card-header-modern.success {
            background-color: var(--accent2);
        }

        .card-header-modern h6 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Search Controls */
        .search-section {
            background-color: var(--gray-100);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .form-control-modern {
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            padding: 12px 16px;
            background-color: var(--white);
            font-weight: 500;
            transition: var(--transition);
        }

        .form-control-modern:focus {
            border-color: var(--accent2);
            box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
            outline: none;
        }

        .input-group-text-modern {
            background-color: var(--accent2);
            border: 2px solid var(--accent2);
            color: white;
            border-radius: 8px 0 0 8px;
            padding: 12px 16px;
        }

        /* Ingredient Items */
        .ingredient-item {
            background-color: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: grab;
            transition: var(--transition);
            border-left: 4px solid var(--accent2);
        }

        .ingredient-item:hover {
            border-color: var(--accent2);
            box-shadow: var(--shadow-sm);
        }

        .ingredient-item:active {
            cursor: grabbing;
        }

        /* Recipe Items */
        .recipe-ingredient {
            background-color: var(--white);
            border: 2px solid var(--gray-200);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--accent);
        }

        /* Buttons */
        .btn-modern {
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            border: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .btn-primary-custom {
            background-color: var(--accent2);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #138496;
            color: white;
        }

        .btn-danger-custom {
            background-color: var(--accent);
            color: white;
        }

        .btn-danger-custom:hover {
            background-color: #c82333;
            color: white;
        }

        /* Drop Zone */
        #recipe-drop-zone {
            transition: var(--transition);
        }

        #recipe-drop-zone.drag-over {
            border-color: var(--accent2);
            background-color: rgba(23, 162, 184, 0.05);
        }

        /* Empty State */
        .empty-state {
            background-color: var(--gray-100);
            border: 2px dashed var(--light);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
        }

        .empty-state:hover {
            border-color: var(--accent2);
        }

        .empty-state i {
            color: var(--accent2);
        }

        /* Nutrition Stats */
        .nutrition-stats {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .stat-item {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .stat-calories {
            color: var(--accent);
        }

        .stat-protein {
            color: #28a745;
        }

        .stat-carb {
            color: #ffc107;
        }

        .stat-fat {
            color: var(--accent2);
        }

        /* Form Controls */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent2);
            box-shadow: 0 0 0 3px rgba(23, 162, 184, 0.1);
        }

        .input-group-text {
            background-color: var(--gray-200);
            border-color: var(--gray-200);
            color: var(--dark);
        }

        /* Badges */
        .badge {
            font-weight: 600;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: var(--dark) !important;
        }

        .bg-info {
            background-color: var(--accent2) !important;
        }

        .bg-primary {
            background-color: var(--accent2) !important;
        }

        .bg-light {
            background-color: var(--gray-100) !important;
            color: var(--dark) !important;
        }

        /* Text Colors */
        .text-primary {
            color: var(--accent2) !important;
        }

        .text-danger {
            color: var(--accent) !important;
        }

        .text-muted {
            color: var(--muted) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nutrition-stats {
                justify-content: center;
            }

            .modern-card {
                margin-bottom: 2rem;
            }

            .search-section {
                padding: 1rem;
            }
        }

        /* Scrollbar */
        .ingredients-list::-webkit-scrollbar {
            width: 6px;
        }

        .ingredients-list::-webkit-scrollbar-track {
            background-color: var(--gray-200);
            border-radius: 3px;
        }

        .ingredients-list::-webkit-scrollbar-thumb {
            background-color: var(--muted);
            border-radius: 3px;
        }

        .ingredients-list::-webkit-scrollbar-thumb:hover {
            background-color: var(--dark);
        }

        /* Rounded Elements */
        .rounded-circle {
            background-color: var(--accent2) !important;
        }

        .recipe-ingredient .rounded-circle {
            background-color: var(--accent) !important;
        }

        /* Remove excessive animations */
        * {
            animation: none !important;
        }

        .ingredient-item,
        .recipe-ingredient {
            transform: none !important;
        }
    </style>

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="page-header text-white text-center py-5 mb-4">
            <div class="container">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-calculator me-3"></i>
                    Nutrition Calculator
                </h1>
                <p class="lead mb-0">Tính toán dinh dưỡng thông minh và chính xác</p>
            </div>
        </div>

        <div class="container">
            <div class="row g-4">
                <!-- Ingredient Library -->
                <div class="col-xl-4 col-lg-5">
                    <div class="modern-card">
                        <div class="card-header-modern success text-white">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-collection-fill me-3 fs-5"></i>
                                <h6>Thư viện nguyên liệu</h6>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <!-- Search Section -->
                            <div class="search-section m-3">
                                <div class="row g-2">
                                    <div class="col-8">
                                        <div class="input-group">
                                            <span class="input-group-text-modern">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <input type="text" id="ingredient-search"
                                                class="form-control form-control-modern" placeholder="Tìm nguyên liệu..."
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <select id="ingredient-filter" class="form-select form-control-modern">
                                            <option value="">Tất cả</option>
                                            <option value="protein">🥩 Protein</option>
                                            <option value="carb">🍞 Carb</option>
                                            <option value="fat">🥑 Fat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Ingredients List -->
                            <div class="ingredients-list px-3 pb-3" style="max-height: 65vh; overflow-y: auto;">
                                @foreach ($ingredients as $ingredient)
                                    <div class="ingredient-item" draggable="true" data-id="{{ $ingredient->id }}"
                                        data-name="{{ $ingredient->name }}" data-unit="{{ $ingredient->unit }}"
                                        data-protein="{{ $ingredient->protein ?? 0 }}"
                                        data-carb="{{ $ingredient->carb ?? 0 }}" data-fat="{{ $ingredient->fat ?? 0 }}"
                                        data-calories="{{ $ingredient->calo ?? 0 }}">

                                        <div class="row align-items-center">
                                            <div class="col-8">
                                                <h6 class="ingredient-name mb-1 fw-bold">{{ $ingredient->name }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-tag-fill me-1"></i>{{ $ingredient->unit }}
                                                </small>
                                            </div>
                                            <div class="col-4 text-end">
                                                <div class="fw-bold text-danger mb-1">{{ $ingredient->calo ?? 0 }} kcal
                                                </div>
                                                <div class="small">
                                                    <span class="badge bg-success me-1">P:
                                                        {{ $ingredient->protein ?? 0 }}</span>
                                                    <span class="badge bg-warning me-1">C:
                                                        {{ $ingredient->carb ?? 0 }}</span>
                                                    <span class="badge bg-info">F: {{ $ingredient->fat ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Instruction -->
                            <div class="bg-light p-3 text-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Kéo thả hoặc nhấp đôi để thêm vào công thức
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recipe Calculator -->
                <div class="col-xl-8 col-lg-7">
                    <div class="modern-card recipe-card" id="recipe-drop-zone" ondrop="drop(event)"
                        ondragover="allowDrop(event)">

                        <div class="card-header-modern text-white">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clipboard-data-fill me-3 fs-5"></i>
                                    <h6>Công thức dinh dưỡng</h6>
                                </div>
                                <div class="nutrition-stats">
                                    <span class="stat-item stat-calories">
                                        <i class="bi bi-fire me-1"></i>
                                        <span id="total-calories">0</span> kcal
                                    </span>
                                    <span class="stat-item stat-protein">
                                        <i class="bi bi-lightning-fill me-1"></i>
                                        P: <span id="total-protein">0</span>g
                                    </span>
                                    <span class="stat-item stat-carb">
                                        <i class="bi bi-droplet-fill me-1"></i>
                                        C: <span id="total-carb">0</span>g
                                    </span>
                                    <span class="stat-item stat-fat">
                                        <i class="bi bi-circle-fill me-1"></i>
                                        F: <span id="total-fat">0</span>g
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="min-height: 400px;">
                            <div id="recipe-container">
                                <div class="empty-state">
                                    <i class="bi bi-arrow-down-up display-1 mb-3"></i>
                                    <h4 class="text-primary mb-3">Bắt đầu tạo công thức</h4>
                                    <p class="text-muted mb-4">
                                        Kéo thả nguyên liệu từ thư viện bên trái hoặc nhấp đôi để thêm vào công thức
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge bg-primary p-2">
                                            <i class="bi bi-mouse me-1"></i>Kéo thả
                                        </span>
                                        <span class="badge bg-success p-2">
                                            <i class="bi bi-hand-index me-1"></i>Nhấp đôi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light border-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Giá trị dinh dưỡng tính theo 100g
                                </small>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-modern btn-primary-custom btn-sm" onclick="exportToExcel()">
                                        <i class="bi bi-download me-1"></i>Xuất kết quả
                                    </button>
                                    <button class="btn btn-modern btn-danger-custom btn-sm"
                                        onclick="clearAllIngredients()">
                                        <i class="bi bi-trash-fill me-1"></i>Xóa tất cả
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        // JavaScript for interactions
        document.addEventListener('DOMContentLoaded', function() {
            initIngredientItems();
            initSearchAndFilter();
        });

        function initIngredientItems() {
            document.querySelectorAll('.ingredient-item').forEach(item => {
                // Drag events
                item.addEventListener('dragstart', function(e) {
                    const data = {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        unit: this.dataset.unit,
                        protein: parseFloat(this.dataset.protein) || 0,
                        carb: parseFloat(this.dataset.carb) || 0,
                        fat: parseFloat(this.dataset.fat) || 0,
                        calories: parseFloat(this.dataset.calories) || 0
                    };
                    e.dataTransfer.setData('ingredient', JSON.stringify(data));
                    this.style.opacity = '0.5';
                });

                item.addEventListener('dragend', function() {
                    this.style.opacity = '1';
                });

                // Double click to add
                item.addEventListener('dblclick', function() {
                    const data = {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        unit: this.dataset.unit,
                        protein: parseFloat(this.dataset.protein) || 0,
                        carb: parseFloat(this.dataset.carb) || 0,
                        fat: parseFloat(this.dataset.fat) || 0,
                        calories: parseFloat(this.dataset.calories) || 0
                    };
                    addIngredientToRecipe(data);
                });
            });
        }

        function initSearchAndFilter() {
            const searchInput = document.getElementById('ingredient-search');
            const filterSelect = document.getElementById('ingredient-filter');

            searchInput.addEventListener('input', function() {
                filterIngredients();
            });

            filterSelect.addEventListener('change', function() {
                filterIngredients();
            });
        }

        function filterIngredients() {
            const searchTerm = document.getElementById('ingredient-search').value.toLowerCase();
            const filterValue = document.getElementById('ingredient-filter').value;

            document.querySelectorAll('.ingredient-item').forEach(item => {
                const name = item.dataset.name.toLowerCase();
                const protein = parseFloat(item.dataset.protein) || 0;
                const carb = parseFloat(item.dataset.carb) || 0;
                const fat = parseFloat(item.dataset.fat) || 0;

                let show = true;

                // Search filter
                if (searchTerm && !name.includes(searchTerm)) {
                    show = false;
                }

                // Category filter
                if (filterValue) {
                    switch (filterValue) {
                        case 'protein':
                            show = show && protein >= Math.max(carb, fat);
                            break;
                        case 'carb':
                            show = show && carb >= Math.max(protein, fat);
                            break;
                        case 'fat':
                            show = show && fat >= Math.max(protein, carb);
                            break;
                    }
                }

                item.style.display = show ? 'block' : 'none';
            });
        }

        function allowDrop(ev) {
            ev.preventDefault();
            ev.currentTarget.classList.add('drag-over');
        }

        function drop(ev) {
            ev.preventDefault();
            ev.currentTarget.classList.remove('drag-over');

            const ingredientData = JSON.parse(ev.dataTransfer.getData('ingredient'));
            addIngredientToRecipe(ingredientData);
        }

        function addIngredientToRecipe(data) {
            const container = document.getElementById('recipe-container');

            // Remove empty state if exists
            const emptyState = container.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            // Check if ingredient already exists
            if (document.querySelector(`[data-recipe-id="${data.id}"]`)) {
                showNotification('Nguyên liệu đã có trong công thức!', 'warning');
                return;
            }

            const ingredientRow = document.createElement('div');
            ingredientRow.className = 'recipe-ingredient';
            ingredientRow.setAttribute('data-recipe-id', data.id);

            ingredientRow.innerHTML = `
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-6 mb-2">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle p-2 me-3">
                        <i class="bi bi-egg text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">${data.name}</h6>
                        <small class="text-muted">${data.unit}</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 mb-2">
                <div class="input-group">
                    <input type="number" class="form-control text-center" value="100" min="0" step="0.1" 
                           onchange="updateNutrition(this, ${data.protein}, ${data.carb}, ${data.fat}, ${data.calories})">
                    <span class="input-group-text">${data.unit}</span>
                </div>
            </div>
            <div class="col-lg-5 col-md-3 mb-2">
                <div class="row text-center">
                    <div class="col-3">
                        <small class="text-muted d-block">Calo</small>
                        <span class="fw-bold text-danger calories">${data.calories}</span>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">P</small>
                        <span class="fw-bold text-success protein">${data.protein}g</span>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">C</small>
                        <span class="fw-bold text-warning carb">${data.carb}g</span>
                    </div>
                    <div class="col-3">
                        <small class="text-muted d-block">F</small>
                        <span class="fw-bold text-info fat">${data.fat}g</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 text-end">
                <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeIngredient(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;

            container.appendChild(ingredientRow);
            updateTotalNutrition();
            showNotification(`Đã thêm ${data.name} vào công thức`, 'success');
        }

        function updateNutrition(input, baseProtein, baseCarb, baseFat, baseCalories) {
            const quantity = parseFloat(input.value) || 0;
            const row = input.closest('.recipe-ingredient');

            const calories = (baseCalories * quantity / 100).toFixed(0);
            const protein = (baseProtein * quantity / 100).toFixed(1);
            const carb = (baseCarb * quantity / 100).toFixed(1);
            const fat = (baseFat * quantity / 100).toFixed(1);

            row.querySelector('.calories').textContent = calories;
            row.querySelector('.protein').textContent = protein + 'g';
            row.querySelector('.carb').textContent = carb + 'g';
            row.querySelector('.fat').textContent = fat + 'g';

            updateTotalNutrition();
        }

        function updateTotalNutrition() {
            const ingredients = document.querySelectorAll('.recipe-ingredient');
            let totalCalories = 0,
                totalProtein = 0,
                totalCarb = 0,
                totalFat = 0;

            ingredients.forEach(ingredient => {
                totalCalories += parseFloat(ingredient.querySelector('.calories').textContent) || 0;
                totalProtein += parseFloat(ingredient.querySelector('.protein').textContent.replace('g', '')) || 0;
                totalCarb += parseFloat(ingredient.querySelector('.carb').textContent.replace('g', '')) || 0;
                totalFat += parseFloat(ingredient.querySelector('.fat').textContent.replace('g', '')) || 0;
            });

            document.getElementById('total-calories').textContent = totalCalories.toFixed(0);
            document.getElementById('total-protein').textContent = totalProtein.toFixed(1);
            document.getElementById('total-carb').textContent = totalCarb.toFixed(1);
            document.getElementById('total-fat').textContent = totalFat.toFixed(1);
        }

        function removeIngredient(button) {
            const row = button.closest('.recipe-ingredient');
            row.remove();
            updateTotalNutrition();

            // Add empty state if no ingredients
            const container = document.getElementById('recipe-container');
            if (container.children.length === 0) {
                container.innerHTML = `
                <div class="empty-state">
                    <i class="bi bi-arrow-down-up display-1 mb-3"></i>
                    <h4 class="text-primary mb-3">Bắt đầu tạo công thức</h4>
                    <p class="text-muted mb-4">
                        Kéo thả nguyên liệu từ thư viện bên trái hoặc nhấp đôi để thêm vào công thức
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-primary p-2">
                            <i class="bi bi-mouse me-1"></i>Kéo thả
                        </span>
                        <span class="badge bg-success p-2">
                            <i class="bi bi-hand-index me-1"></i>Nhấp đôi
                        </span>
                    </div>
                </div>
            `;
            }

            showNotification('Đã xóa nguyên liệu', 'info');
        }

        function clearAllIngredients() {
            if (confirm('Bạn có chắc chắn muốn xóa tất cả nguyên liệu?')) {
                const container = document.getElementById('recipe-container');
                container.innerHTML = `
            <div class="empty-state">
                <i class="bi bi-arrow-down-up display-1 mb-3"></i>
                <h4 class="text-primary mb-3">Bắt đầu tạo công thức</h4>
                <p class="text-muted mb-4">
                    Kéo thả nguyên liệu từ thư viện bên trái hoặc nhấp đôi để thêm vào công thức
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <span class="badge bg-primary p-2">
                        <i class="bi bi-mouse me-1"></i>Kéo thả
                    </span>
                    <span class="badge bg-success p-2">
                        <i class="bi bi-hand-index me-1"></i>Nhấp đôi
                    </span>
                </div>
            </div>
        `;
                updateTotalNutrition();
                showNotification('Đã xóa tất cả nguyên liệu', 'info');
            }
        }

        function showNotification(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';

            toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 3000);
        }
        // Xuất file excel
        function exportToExcel() {
            const ingredients = document.querySelectorAll('.recipe-ingredient');

            // Kiểm tra có nguyên liệu không
            if (ingredients.length === 0) {
                showNotification('Chưa có nguyên liệu nào để xuất!', 'warning');
                return;
            }

            // Tạo dữ liệu cho Excel
            const data = [];

            // Header
            data.push([
                'STT',
                'Tên nguyên liệu',
                'Khối lượng',
                'Đơn vị',
                'Calories (kcal)',
                'Protein (g)',
                'Carb (g)',
                'Fat (g)'
            ]);

            // Thêm dữ liệu nguyên liệu
            ingredients.forEach((ingredient, index) => {
                const name = ingredient.querySelector('h6').textContent;
                const unit = ingredient.querySelector('small').textContent;
                const quantity = ingredient.querySelector('input[type="number"]').value;
                const calories = ingredient.querySelector('.calories').textContent;
                const protein = parseFloat(ingredient.querySelector('.protein').textContent.replace('g', ''));
                const carb = parseFloat(ingredient.querySelector('.carb').textContent.replace('g', ''));
                const fat = parseFloat(ingredient.querySelector('.fat').textContent.replace('g', ''));

                data.push([
                    index + 1,
                    name,
                    quantity,
                    unit,
                    parseFloat(calories),
                    protein,
                    carb,
                    fat
                ]);
            });

            // Thêm dòng trống
            data.push(['', '', '', '', '', '', '', '']);

            // Thêm tổng kết
            const totalCalories = document.getElementById('total-calories').textContent;
            const totalProtein = document.getElementById('total-protein').textContent;
            const totalCarb = document.getElementById('total-carb').textContent;
            const totalFat = document.getElementById('total-fat').textContent;

            data.push([
                '',
                'TỔNG CỘNG',
                '',
                '',
                parseFloat(totalCalories),
                parseFloat(totalProtein),
                parseFloat(totalCarb),
                parseFloat(totalFat)
            ]);

            // Thêm thông tin bổ sung
            data.push(['', '', '', '', '', '', '', '']);
            data.push(['Thông tin bổ sung:', '', '', '', '', '', '', '']);
            data.push(['Ngày tạo:', new Date().toLocaleDateString('vi-VN'), '', '', '', '', '', '']);
            data.push(['Thời gian:', new Date().toLocaleTimeString('vi-VN'), '', '', '', '', '', '']);
            data.push(['Tạo bởi:', 'Nutri-Planner Calculator', '', '', '', '', '', '']);

            // Tạo workbook và worksheet
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(data);

            // Styling cho Excel
            const range = XLSX.utils.decode_range(ws['!ref']);

            // Auto-fit columns
            const colWidths = [{
                    wch: 5
                }, // STT
                {
                    wch: 25
                }, // Tên nguyên liệu
                {
                    wch: 12
                }, // Khối lượng
                {
                    wch: 10
                }, // Đơn vị
                {
                    wch: 15
                }, // Calories
                {
                    wch: 12
                }, // Protein
                {
                    wch: 12
                }, // Carb
                {
                    wch: 12
                } // Fat
            ];
            ws['!cols'] = colWidths;

            // Merge cells cho tiêu đề "TỔNG CỘNG"
            if (!ws['!merges']) ws['!merges'] = [];

            // Style cho header
            for (let col = 0; col <= 7; col++) {
                const cellAddr = XLSX.utils.encode_cell({
                    r: 0,
                    c: col
                });
                if (!ws[cellAddr]) continue;
                ws[cellAddr].s = {
                    font: {
                        bold: true,
                        color: {
                            rgb: "FFFFFF"
                        }
                    },
                    fill: {
                        fgColor: {
                            rgb: "17A2B8"
                        }
                    },
                    alignment: {
                        horizontal: "center",
                        vertical: "center"
                    }
                };
            }

            // Style cho dòng tổng cộng
            const totalRowIndex = data.length - 5; // Vị trí dòng "TỔNG CỘNG"
            for (let col = 0; col <= 7; col++) {
                const cellAddr = XLSX.utils.encode_cell({
                    r: totalRowIndex,
                    c: col
                });
                if (!ws[cellAddr]) continue;
                ws[cellAddr].s = {
                    font: {
                        bold: true
                    },
                    fill: {
                        fgColor: {
                            rgb: "F8F9FA"
                        }
                    },
                    border: {
                        top: {
                            style: "thick"
                        },
                        bottom: {
                            style: "thick"
                        }
                    }
                };
            }

            // Thêm worksheet vào workbook
            XLSX.utils.book_append_sheet(wb, ws, "Nutrition Calculator");

            // Tạo tên file với timestamp
            const now = new Date();
            const timestamp = now.toISOString().slice(0, 19).replace(/[:-]/g, '').replace('T', '_');
            const filename = `nutrition_calculator_${timestamp}.xlsx`;

            // Xuất file
            try {
                XLSX.writeFile(wb, filename);
                showNotification('Đã xuất file Excel thành công!', 'success');
            } catch (error) {
                console.error('Lỗi khi xuất file:', error);
                showNotification('Có lỗi xảy ra khi xuất file!', 'danger');
            }
        }

        // Hàm xuất PDF (bonus - nếu cần)
        function exportToPDF() {
            const ingredients = document.querySelectorAll('.recipe-ingredient');

            if (ingredients.length === 0) {
                showNotification('Chưa có nguyên liệu nào để xuất!', 'warning');
                return;
            }

            // Tạo nội dung HTML để in
            let htmlContent = `
        <div style="font-family: Arial, sans-serif; padding: 20px;">
            <h1 style="text-align: center; color: #17A2B8;">Kết quả tính toán dinh dưỡng</h1>
            <p style="text-align: center; color: #6C757D;">Ngày tạo: ${new Date().toLocaleDateString('vi-VN')} - ${new Date().toLocaleTimeString('vi-VN')}</p>
            
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr style="background-color: #17A2B8; color: white;">
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">STT</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: left;">Nguyên liệu</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Khối lượng</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Calories</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Protein</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Carb</th>
                        <th style="border: 1px solid #ddd; padding: 12px; text-align: center;">Fat</th>
                    </tr>
                </thead>
                <tbody>
    `;

            ingredients.forEach((ingredient, index) => {
                const name = ingredient.querySelector('h6').textContent;
                const unit = ingredient.querySelector('small').textContent;
                const quantity = ingredient.querySelector('input[type="number"]').value;
                const calories = ingredient.querySelector('.calories').textContent;
                const protein = ingredient.querySelector('.protein').textContent;
                const carb = ingredient.querySelector('.carb').textContent;
                const fat = ingredient.querySelector('.fat').textContent;

                htmlContent += `
            <tr style="${index % 2 === 0 ? 'background-color: #f8f9fa;' : ''}">
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">${index + 1}</td>
                <td style="border: 1px solid #ddd; padding: 8px;">${name}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">${quantity} ${unit}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">${calories} kcal</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">${protein}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">${carb}</td>
                <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">${fat}</td>
            </tr>
        `;
            });

            const totalCalories = document.getElementById('total-calories').textContent;
            const totalProtein = document.getElementById('total-protein').textContent;
            const totalCarb = document.getElementById('total-carb').textContent;
            const totalFat = document.getElementById('total-fat').textContent;

            htmlContent += `
                </tbody>
                <tfoot>
                    <tr style="background-color: #343941; color: white; font-weight: bold;">
                        <td colspan="3" style="border: 1px solid #ddd; padding: 12px; text-align: center;">TỔNG CỘNG</td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">${totalCalories} kcal</td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">${totalProtein}g</td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">${totalCarb}g</td>
                        <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">${totalFat}g</td>
                    </tr>
                </tfoot>
            </table>
            
            <div style="margin-top: 30px; text-align: center; color: #6C757D; font-size: 12px;">
                <p>Tạo bởi Nutri-Planner Calculator</p>
            </div>
        </div>
    `;

            // Mở cửa sổ in
            const printWindow = window.open('', '_blank');
            printWindow.document.write(htmlContent);
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection
