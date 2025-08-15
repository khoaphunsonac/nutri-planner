@extends('site.layout')

@section('content')
    <style>
        /* Color Variables */
        :root {
            --dark: #111111;
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
            /* border-radius: var(--border-radius); */
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            width: 100%;
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

    <div class="container-main">
        <!-- Header -->
        <div class="page-header text-white text-center py-5">
            <div class="container">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-calculator me-3"></i>
                    Nutrition Calculator
                </h1>
                <p class="lead mb-0">Tính toán dinh dưỡng thông minh và chính xác</p>
            </div>
        </div>

        <div class="container" style="max-width: 1600px;">
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
    <script src="{{ asset('assets/user/js/nutri-calc.js') }}"></script>
@endsection
