{{-- filepath: c:\laragon\www\nutri-planner\resources\views\site\nutri-calc.blade.php --}}
@extends('site.layout')

@section('content')
@php
    // màu theme - cập nhật hiện đại hơn
    $dark = '#2C3E50';
    $muted = '#7F8C8D';
    $light = '#ECF0F1';
    $accent = '#E74C3C';
    $accent2 = '#3498DB';
    $success = '#27AE60';
    $warning = '#F39C12';
@endphp

<style>
    :root {
        --dark: {{ $dark }};
        --muted: {{ $muted }};
        --light: {{ $light }};
        --accent: {{ $accent }};
        --accent2: {{ $accent2 }};
        --success: {{ $success }};
        --warning: {{ $warning }};
        --gradient-primary: linear-gradient(135deg, {{ $accent }}, {{ $accent2 }});
        --gradient-dark: linear-gradient(135deg, {{ $dark }}, #34495E);
        --shadow-sm: 0 2px 10px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.12);
        --shadow-lg: 0 8px 30px rgba(0,0,0,0.15);
        --border-radius: 12px;
        --border-radius-lg: 20px;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Header modernized */
    .nutri-header {
        background: var(--gradient-dark);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .nutri-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    .nutri-header .card-body {
        position: relative;
        z-index: 1;
        padding: 2rem;
    }

    /* Modern badges */
    .badge-nutr {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        border: 1px solid rgba(255,255,255,0.2);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .badge-nutr:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-2px);
    }

    /* Cards modernized */
    .modern-card {
        background: white;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .modern-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .modern-card .card-header {
        background: var(--gradient-dark);
        border: none;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        padding: 1.5rem;
        position: relative;
    }

    .modern-card .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        pointer-events: none;
    }

    /* Ingredient panel modernized */
    #ingredients-panel {
        display: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ingredient-item {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: var(--border-radius);
        cursor: grab;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .ingredient-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gradient-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .ingredient-item:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-3px);
        border-color: var(--accent2);
    }

    .ingredient-item:hover::before {
        opacity: 1;
    }

    .ingredient-item:active {
        cursor: grabbing;
        transform: rotate(2deg) scale(1.02);
    }

    /* Recipe area modernized */
    .recipe-ingredient-row {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .recipe-ingredient-row::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--success);
    }

    .recipe-ingredient-row:hover {
        box-shadow: var(--shadow-sm);
        transform: translateY(-1px);
    }

    /* Modern buttons */
    .btn-modern {
        border-radius: 25px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-accent {
        background: var(--gradient-primary);
        color: white;
    }

    .btn-accent:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
    }

    .btn-accent2 {
        background: var(--accent2);
        color: white;
    }

    .btn-accent2:hover {
        background: #2980B9;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
    }

    /* Form controls modernized */
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: var(--border-radius);
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent2);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        transform: translateY(-1px);
    }

    /* Empty state modernized */
    .empty-state {
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border: 2px dashed #dee2e6;
        border-radius: var(--border-radius);
        padding: 3rem 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .empty-state:hover {
        border-color: var(--accent2);
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
    }

    /* Drop zone animation */
    #recipe-drop-zone.border-3 {
        border-color: var(--accent2) !important;
        background: rgba(52, 152, 219, 0.05);
        transform: scale(1.02);
    }

    /* Scrollbar styling */
    .ingredients-list::-webkit-scrollbar {
        width: 6px;
    }

    .ingredients-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .ingredients-list::-webkit-scrollbar-thumb {
        background: var(--muted);
        border-radius: 3px;
    }

    .ingredients-list::-webkit-scrollbar-thumb:hover {
        background: var(--dark);
    }

    /* Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes bounceIn {
        0% { transform: scale(0.3); opacity: 0; }
        50% { transform: scale(1.05); }
        70% { transform: scale(0.9); }
        100% { transform: scale(1); opacity: 1; }
    }

    .panel-show {
        animation: slideInLeft 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ingredient-added {
        animation: bounceIn 0.5s ease;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .nutri-header .card-body {
            padding: 1.5rem;
        }
        
        .badge-nutr {
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
        }

        #ingredients-panel {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1050;
            background: white;
            padding: 1rem;
            overflow-y: auto;
        }
    }

    /* Loading states */
    .loading {
        position: relative;
        pointer-events: none;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid var(--accent);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Modern toggle button */
    .toggle-panel-btn {
        position: relative;
        background: var(--gradient-primary);
        border: none;
        border-radius: 50px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .toggle-panel-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-md);
    }

    .toggle-panel-btn i {
        transition: transform 0.3s ease;
    }

    .toggle-panel-btn.active i {
        transform: rotate(180deg);
    }
</style>

<div class="container-fluid my-4">
    <!-- Modern Header -->
    <div class="nutri-header mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-2 text-white fw-bold">🥗 Nutrition Calculator</h2>
                    <p class="mb-0 text-white-50 fs-6">Tính toán dinh dưỡng thông minh với công nghệ hiện đại</p>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex flex-wrap justify-content-lg-end justify-content-start gap-2 mt-3 mt-lg-0">
                        <div class="badge-nutr">
                            <i class="bi bi-lightning-fill me-1"></i>
                            P: <span id="total-protein" class="fw-bold">0</span>g
                        </div>
                        <div class="badge-nutr">
                            <i class="bi bi-droplet-fill me-1"></i>
                            C: <span id="total-carb" class="fw-bold">0</span>g
                        </div>
                        <div class="badge-nutr">
                            <i class="bi bi-circle-fill me-1"></i>
                            F: <span id="total-fat" class="fw-bold">0</span>g
                        </div>
                        <div class="badge-nutr">
                            <i class="bi bi-fire me-1"></i>
                            <span id="total-calories" class="fw-bold">0</span> kcal
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Ingredients Panel - Hidden by default -->
        <div class="col-xl-4 col-lg-5" id="ingredients-panel">
            <div class="modern-card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white">
                            <i class="bi bi-collection me-2"></i>Thư viện nguyên liệu
                        </h6>
                        <button class="btn btn-outline-light btn-sm d-lg-none" onclick="toggleIngredientPanel()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Search and Filter -->
                    <div class="row g-2 mb-3">
                        <div class="col-8">
                            <div class="position-relative">
                                <i class="bi bi-search position-absolute" style="left: 1rem; top: 50%; transform: translateY(-50%); color: var(--muted);"></i>
                                <input id="ingredient-search" type="text" class="form-control ps-5" 
                                       placeholder="Tìm kiếm nguyên liệu..." value="{{ $search ?? '' }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <select id="ingredient-filter" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="protein">🥩 Protein</option>
                                <option value="carb">🍞 Carb</option>
                                <option value="fat">🥑 Fat</option>
                                <option value="vegetable">🥬 Rau củ</option>
                                <option value="spice">🧂 Gia vị</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ingredients List -->
                    <div class="ingredients-list" style="max-height: 65vh; overflow-y: auto;">
                        @foreach($ingredients as $ingredient)
                            <div class="ingredient-item mb-2 p-3 d-flex justify-content-between align-items-center"
                                draggable="true"
                                data-id="{{ $ingredient->id }}"
                                data-name="{{ $ingredient->name }}"
                                data-unit="{{ $ingredient->unit }}"
                                data-protein="{{ $ingredient->protein ?? 0 }}"
                                data-carb="{{ $ingredient->carb ?? 0 }}"
                                data-fat="{{ $ingredient->fat ?? 0 }}"
                                data-calories="{{ $ingredient->calo ?? 0 }}">
                                
                                <div class="flex-grow-1">
                                    <div class="fw-semibold ingredient-name text-dark">{{ $ingredient->name }}</div>
                                    <div class="text-muted small">
                                        <i class="bi bi-tag me-1"></i>{{ $ingredient->unit }}
                                    </div>
                                </div>
                                
                                <div class="text-end">
                                    <div class="fw-bold text-primary mb-1">{{ $ingredient->calo ?? 0 }} kcal</div>
                                    <div class="small text-muted">
                                        <span class="badge bg-light text-dark me-1">P: {{ $ingredient->protein ?? 0 }}</span>
                                        <span class="badge bg-light text-dark me-1">C: {{ $ingredient->carb ?? 0 }}</span>
                                        <span class="badge bg-light text-dark">F: {{ $ingredient->fat ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-3 p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Kéo thả hoặc nhấp đôi để thêm nguyên liệu
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipe Calculator -->
        <div class="col-xl-8 col-lg-7" id="recipe-column">
            <div class="modern-card" id="recipe-drop-zone" ondrop="drop(event)" ondragover="allowDrop(event)">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white">
                            <i class="bi bi-calculator me-2"></i>Công thức dinh dưỡng
                        </h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-light btn-sm btn-modern" onclick="toggleIngredientPanel()">
                                <i class="bi bi-collection me-1"></i>
                                <span class="d-none d-sm-inline">Thư viện</span>
                            </button>
                            <button class="btn btn-outline-danger btn-sm btn-modern" onclick="clearAllIngredients()">
                                <i class="bi bi-trash me-1"></i>
                                <span class="d-none d-sm-inline">Xóa tất cả</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="min-height: 400px;">
                    <div id="ingredients-container">
                        <div class="empty-state">
                            <div class="mb-3">
                                <i class="bi bi-arrow-down-up text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-primary mb-2">Bắt đầu tạo công thức</h5>
                            <p class="text-muted mb-3">Kéo thả nguyên liệu từ thư viện hoặc nhấp đôi để thêm</p>
                            <button class="btn btn-accent2 btn-modern" onclick="toggleIngredientPanel()">
                                <i class="bi bi-plus-circle me-2"></i>Mở thư viện nguyên liệu
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Giá trị dinh dưỡng được tính theo cơ sở 100g và điều chỉnh theo số lượng thực tế
                            </small>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <button class="btn btn-accent2 btn-modern mt-2 mt-lg-0" onclick="exportSummary()">
                                <i class="bi bi-download me-2"></i>Xuất kết quả
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button for Mobile -->
    <div class="d-lg-none position-fixed" style="bottom: 2rem; right: 2rem; z-index: 1000;">
        <button class="toggle-panel-btn" onclick="toggleIngredientPanel()" id="fab-toggle">
            <i class="bi bi-collection"></i>
        </button>
    </div>
</div>

{{-- Enhanced JavaScript --}}
<script>
    // Enhanced state management
    let ingredientIndex = 0;
    let totals = { protein: 0, carb: 0, fat: 0, calo: 0 };
    let panelVisible = false;

    // Enhanced helpers
    function formatNum(v, dec=1) { 
        return (Math.round((v + Number.EPSILON) * Math.pow(10, dec)) / Math.pow(10, dec)).toFixed(dec); 
    }

    // Enhanced initialization
    document.addEventListener('DOMContentLoaded', () => {
        initIngredientItems();
        initSearchAndFilter();
        updateToggleButton();
        
        // Add loading animation
        document.body.classList.add('loading');
        setTimeout(() => {
            document.body.classList.remove('loading');
        }, 500);
    });

    /* Enhanced Drag & Drop */
    function initIngredientItems() {
        document.querySelectorAll('.ingredient-item').forEach(item => {
            // Enhanced drag events
            item.addEventListener('dragstart', function(e) {
                e.dataTransfer.setData('ingredient', JSON.stringify({
                    id: this.dataset.id,
                    name: this.dataset.name,
                    unit: this.dataset.unit,
                    protein: parseFloat(this.dataset.protein) || 0,
                    carb: parseFloat(this.dataset.carb) || 0,
                    fat: parseFloat(this.dataset.fat) || 0,
                    calories: parseFloat(this.dataset.calories) || 0
                }));
                this.style.opacity = '0.6';
                this.style.transform = 'rotate(5deg)';
            });

            item.addEventListener('dragend', function(e) {
                this.style.opacity = '1';
                this.style.transform = 'none';
            });

            // Enhanced double click
            item.addEventListener('dblclick', function() {
                const payload = {
                    id: this.dataset.id,
                    name: this.dataset.name,
                    unit: this.dataset.unit,
                    protein: parseFloat(this.dataset.protein) || 0,
                    carb: parseFloat(this.dataset.carb) || 0,
                    fat: parseFloat(this.dataset.fat) || 0,
                    calories: parseFloat(this.dataset.calories) || 0
                };
                
                if (isIngredientExists(payload.id)) {
                    showToast('Nguyên liệu đã có trong công thức!', 'warning');
                    return;
                }
                
                addRecipeIngredient(payload);
                showToast(`Đã thêm ${payload.name}`, 'success');
                
                // Add visual feedback
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'none';
                }, 200);
            });

            // Enhanced hover effects
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'none';
            });
        });
    }

    function allowDrop(ev) { 
        ev.preventDefault(); 
        ev.currentTarget.classList.add('border-3');
        ev.currentTarget.style.borderColor = 'var(--accent2)';
    }

    function drop(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.remove('border-3');
        ev.currentTarget.style.borderColor = '';
        
        let json = ev.dataTransfer.getData('ingredient');
        if (!json) return;
        
        const payload = JSON.parse(json);
        if (isIngredientExists(payload.id)) {
            showToast('Nguyên liệu đã có trong công thức!', 'warning');
            return;
        }
        
        addRecipeIngredient(payload);
        showToast(`Đã thêm ${payload.name}`, 'success');
    }

    function isIngredientExists(id) {
        return document.querySelector(`input[name="ingredients[${id}]"]`) !== null;
    }

    /* Enhanced Recipe Management */
    function addRecipeIngredient(data) {
        const container = document.getElementById('ingredients-container');
        const empty = container.querySelector('.empty-state');
        if (empty) empty.remove();

        const row = document.createElement('div');
        row.className = 'recipe-ingredient-row mb-3 p-3 ingredient-added';
        row.dataset.id = data.id;

        const quantityDefault = 100;

        row.innerHTML = `
            <div class="row align-items-center g-3">
                <div class="col-lg-5 col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-egg text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark">${data.name}</div>
                            <small class="text-muted">
                                <i class="bi bi-tag me-1"></i>${data.unit}
                            </small>
                        </div>
                    </div>
                    <input type="hidden" name="ingredients[${data.id}]" value="${data.id}">
                    <input type="hidden" class="base-protein" value="${data.protein}">
                    <input type="hidden" class="base-carb" value="${data.carb}">
                    <input type="hidden" class="base-fat" value="${data.fat}">
                    <input type="hidden" class="base-calories" value="${data.calories}">
                </div>

                <div class="col-lg-2 col-md-3">
                    <div class="input-group">
                        <input type="number" class="form-control quantity-input text-center fw-bold" 
                               value="${quantityDefault}" min="0" step="0.1"
                               onchange="calculateNutrition(this)">
                        <span class="input-group-text small">${data.unit}</span>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="nutrition-info">
                        <div class="row g-1 text-center">
                            <div class="col-6">
                                <div class="small text-muted">Calories</div>
                                <div class="fw-bold text-primary calories">${formatNum((data.calories * quantityDefault)/100,0)}</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Protein</div>
                                <div class="fw-bold text-success protein">${formatNum((data.protein * quantityDefault)/100,1)}g</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Carb</div>
                                <div class="fw-bold text-warning carb">${formatNum((data.carb * quantityDefault)/100,1)}g</div>
                            </div>
                            <div class="col-6">
                                <div class="small text-muted">Fat</div>
                                <div class="fw-bold text-info fat">${formatNum((data.fat * quantityDefault)/100,1)}g</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-1 col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" 
                            onclick="removeRecipeIngredient(this)" title="Xóa nguyên liệu">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(row);
        ingredientIndex++;
        calculateNutrition(row.querySelector('.quantity-input'));
        updateTotalNutrition();

        // Enhanced animation
        row.style.opacity = 0;
        row.style.transform = 'translateY(20px)';
        setTimeout(() => { 
            row.style.transition = 'all 0.4s ease';
            row.style.opacity = 1; 
            row.style.transform = 'translateY(0)'; 
        }, 50);
    }

    function removeRecipeIngredient(btn) {
        const row = btn.closest('.recipe-ingredient-row');
        
        // Enhanced removal animation
        row.style.transform = 'translateX(100px)';
        row.style.opacity = '0';
        
        setTimeout(() => {
            row.remove();
            updateTotalNutrition();
            
            const container = document.getElementById('ingredients-container');
            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="mb-3">
                            <i class="bi bi-arrow-down-up text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-primary mb-2">Bắt đầu tạo công thức</h5>
                        <p class="text-muted mb-3">Kéo thả nguyên liệu từ thư viện hoặc nhấp đôi để thêm</p>
                        <button class="btn btn-accent2 btn-modern" onclick="toggleIngredientPanel()">
                            <i class="bi bi-plus-circle me-2"></i>Mở thư viện nguyên liệu
                        </button>
                    </div>
                `;
            }
        }, 300);
        
        showToast('Đã xóa nguyên liệu', 'info');
    }

    function clearAllIngredients() {
        if (!confirm('Bạn có chắc chắn muốn xóa tất cả nguyên liệu?')) return;
        
        const container = document.getElementById('ingredients-container');
        const rows = container.querySelectorAll('.recipe-ingredient-row');
        
        rows.forEach((row, index) => {
            setTimeout(() => {
                row.style.transform = 'translateX(100px)';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 200);
            }, index * 100);
        });
        
        setTimeout(() => {
            container.innerHTML = `
                <div class="empty-state">
                    <div class="mb-3">
                        <i class="bi bi-arrow-down-up text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-primary mb-2">Bắt đầu tạo công thức</h5>
                    <p class="text-muted mb-3">Kéo thả nguyên liệu từ thư viện hoặc nhấp đôi để thêm</p>
                    <button class="btn btn-accent2 btn-modern" onclick="toggleIngredientPanel()">
                        <i class="bi bi-plus-circle me-2"></i>Mở thư viện nguyên liệu
                    </button>
                </div>
            `;
            totals = { protein:0, carb:0, fat:0, calo:0 };
            updateTotalsOnUI();
        }, rows.length * 100 + 200);
        
        showToast('Đã xóa tất cả nguyên liệu', 'info');
    }

    /* Enhanced Calculations */
    function calculateNutrition(quantityInput) {
        const row = quantityInput.closest('.recipe-ingredient-row');
        const q = parseFloat(quantityInput.value) || 0;
        const baseP = parseFloat(row.querySelector('.base-protein').value) || 0;
        const baseC = parseFloat(row.querySelector('.base-carb').value) || 0;
        const baseF = parseFloat(row.querySelector('.base-fat').value) || 0;
        const baseCal = parseFloat(row.querySelector('.base-calories').value) || 0;

        const actualP = (baseP * q / 100);
        const actualC = (baseC * q / 100);
        const actualF = (baseF * q / 100);
        const actualCal = (baseCal * q / 100);

        row.querySelector('.protein').textContent = formatNum(actualP,1) + 'g';
        row.querySelector('.carb').textContent = formatNum(actualC,1) + 'g';
        row.querySelector('.fat').textContent = formatNum(actualF,1) + 'g';
        row.querySelector('.calories').textContent = formatNum(actualCal,0);

        updateTotalNutrition();
    }

    function updateTotalNutrition() {
        const rows = document.querySelectorAll('.recipe-ingredient-row');
        let P=0,C=0,F=0,Cal=0;
        
        rows.forEach(r => {
            P += parseFloat(r.querySelector('.protein').textContent.replace('g', '')) || 0;
            C += parseFloat(r.querySelector('.carb').textContent.replace('g', '')) || 0;
            F += parseFloat(r.querySelector('.fat').textContent.replace('g', '')) || 0;
            Cal += parseFloat(r.querySelector('.calories').textContent) || 0;
        });
        
        totals = { protein: P, carb: C, fat: F, calo: Cal };
        updateTotalsOnUI();
    }

    function updateTotalsOnUI() {
        // Animate number changes
        animateNumber('total-protein', totals.protein, 1);
        animateNumber('total-carb', totals.carb, 1);
        animateNumber('total-fat', totals.fat, 1);
        animateNumber('total-calories', totals.calo, 0);
    }

    function animateNumber(elementId, targetValue, decimals) {
        const element = document.getElementById(elementId);
        const currentValue = parseFloat(element.textContent) || 0;
        const increment = (targetValue - currentValue) / 20;
        
        let current = currentValue;
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= targetValue) || (increment < 0 && current <= targetValue)) {
                current = targetValue;
                clearInterval(timer);
            }
            element.textContent = formatNum(current, decimals);
        }, 20);
    }

    /* Enhanced Search & Filter */
    function initSearchAndFilter() {
        const searchEl = document.getElementById('ingredient-search');
        const filterEl = document.getElementById('ingredient-filter');

        function apply() {
            const q = searchEl.value.trim().toLowerCase();
            const f = filterEl.value;
            filterIngredients(q,f);
        }

        searchEl.addEventListener('input', debounce(apply, 300));
        filterEl.addEventListener('change', apply);
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function filterIngredients(searchTerm, filter) {
        const items = document.querySelectorAll('.ingredient-item');
        let visible = 0;
        
        items.forEach(item => {
            const name = item.querySelector('.ingredient-name').textContent.toLowerCase();
            const protein = parseFloat(item.dataset.protein) || 0;
            const carb = parseFloat(item.dataset.carb) || 0;
            const fat = parseFloat(item.dataset.fat) || 0;
            
            let okSearch = name.includes(searchTerm);
            let okFilter = true;
            
            if (filter) {
                if (filter === 'protein') okFilter = (protein >= carb && protein >= fat);
                if (filter === 'carb') okFilter = (carb >= protein && carb >= fat);
                if (filter === 'fat') okFilter = (fat >= protein && fat >= carb);
                if (filter === 'vegetable') okFilter = /rau|củ|lá|cà|nấm|xà lách/i.test(name);
                if (filter === 'spice') okFilter = /muối|tiêu|gia vị|hành|tỏi|gừng/i.test(name);
            }
            
            const show = okSearch && okFilter;
            item.style.display = show ? 'flex' : 'none';
            if (show) visible++;
        });

        // Enhanced no results message
        const list = document.querySelector('.ingredients-list');
        const existing = list.querySelector('.no-results-message');
        if (existing) existing.remove();
        
        if (visible === 0) {
            const no = document.createElement('div');
            no.className = 'no-results-message text-center py-4';
            no.innerHTML = `
                <div class="mb-3">
                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                </div>
                <h6 class="text-muted">Không tìm thấy nguyên liệu</h6>
                <p class="text-muted small mb-0">Thử tìm kiếm với từ khóa khác</p>
            `;
            list.appendChild(no);
        }
    }

    /* Enhanced Panel Toggle */
    function toggleIngredientPanel() {
        const panel = document.getElementById('ingredients-panel');
        const recipeColumn = document.getElementById('recipe-column');
        
        if (!panel || !recipeColumn) return;
        
        if (panelVisible) {
            // Hide panel
            panel.style.display = 'none';
            recipeColumn.className = 'col-12';
            panelVisible = false;
        } else {
            // Show panel
            panel.style.display = 'block';
            panel.classList.add('panel-show');
            recipeColumn.className = 'col-xl-8 col-lg-7';
            panelVisible = true;
            
            setTimeout(() => {
                const searchInput = document.getElementById('ingredient-search');
                if (searchInput) searchInput.focus();
            }, 100);
        }
        
        updateToggleButton();
    }

    function updateToggleButton() {
        const fabToggle = document.getElementById('fab-toggle');
        if (fabToggle) {
            const icon = fabToggle.querySelector('i');
            if (panelVisible) {
                icon.className = 'bi bi-x-lg';
                fabToggle.classList.add('active');
            } else {
                icon.className = 'bi bi-collection';
                fabToggle.classList.remove('active');
            }
        }
    }

    /* Enhanced Toast System */
    function showToast(message, type = 'info') {
        const toastContainer = getOrCreateToastContainer();
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${getBootstrapColor(type)} border-0 show`;
        toast.style.minWidth = '250px';
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${getToastIcon(type)} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }, 3000);
    }

    function getOrCreateToastContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
        }
        return container;
    }

    function getBootstrapColor(type) {
        const colors = {
            'success': 'success',
            'error': 'danger',
            'warning': 'warning',
            'info': 'info'
        };
        return colors[type] || 'info';
    }

    function getToastIcon(type) {
        const icons = {
            'success': 'bi-check-circle-fill',
            'error': 'bi-x-circle-fill',
            'warning': 'bi-exclamation-triangle-fill',
            'info': 'bi-info-circle-fill'
        };
        return icons[type] || 'bi-info-circle-fill';
    }

    /* Enhanced Export */
    function exportSummary() {
        const summary = {
            timestamp: new Date().toISOString(),
            total_nutrition: {
                protein: totals.protein,
                carb: totals.carb,
                fat: totals.fat,
                calories: totals.calo
            },
            ingredients: Array.from(document.querySelectorAll('.recipe-ingredient-row')).map(r => ({
                id: r.dataset.id,
                name: r.querySelector('.fw-semibold').textContent,
                quantity: r.querySelector('.quantity-input').value,
                unit: r.querySelector('.input-group-text').textContent,
                nutrition: {
                    protein: r.querySelector('.protein').textContent,
                    carb: r.querySelector('.carb').textContent,
                    fat: r.querySelector('.fat').textContent,
                    calories: r.querySelector('.calories').textContent
                }
            }))
        };
        
        const blob = new Blob([JSON.stringify(summary, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        const filename = `nutrition-summary-${new Date().toISOString().slice(0,10)}.json`;
        
        a.href = url; 
        a.download = filename; 
        document.body.appendChild(a);
        a.click(); 
        a.remove(); 
        URL.revokeObjectURL(url);
        
        showToast('Đã xuất file thành công!', 'success');
    }

    // Legacy function for compatibility
    function toast(msg, type='info') {
        showToast(msg, type);
    }
</script>
@endsection