@extends('site.layout')

{{-- @section('title', 'Nutri Calculator') --}}

@section('content')
@php
    // màu theme
    $dark = '#343941';
    $muted = '#6C757D';
    $light = '#ADB5BD';
    $accent = '#E83850';
    $accent2 = '#17A2B8';
@endphp

<style>
    /* Theme */
    .nutri-header { background: {{ $dark }}; color: white; }
    .btn-accent { background: {{ $accent }}; color: white; border: none; }
    .btn-accent2 { background: {{ $accent2 }}; color: white; border: none; }
    .ingredient-item { cursor: grab; }
    .ingredient-item:active { cursor: grabbing; }
    .ingredient-item:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.12); transform: translateY(-2px); }
    .recipe-ingredient-row { transition: all .25s ease; }
    .no-results-message { color: {{ $muted }}; }
    .badge-nutr { background: {{ $light }}; color: {{ $dark }}; padding:.25rem .4rem; border-radius:.25rem; }
    /* Ẩn ingredients panel mặc định */
    #ingredients-panel { 
        display: none; 
        transition: all 0.3s ease;
    }
    /* responsive small custom */
    @media (max-width: 767px) {
        #ingredients-panel { display: none !important; }
    }
</style>

<div class="container my-5">
    <div class="card nutri-header mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-0">Nutri Calculator</h3>
                <small class="text-white-50">Tính nhanh Protein / Carb / Fat / Calories theo nguyên liệu</small>
            </div>
            <div class="text-end">
                <div class="fs-6">
                    <span class="badge-nutr me-2">P: <span id="total-protein">0</span> g</span>
                    <span class="badge-nutr me-2">C: <span id="total-carb">0</span> g</span>
                    <span class="badge-nutr me-2">F: <span id="total-fat">0</span> g</span>
                    <span class="badge-nutr">Kcal: <span id="total-calories">0</span></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Left: Ingredients panel --}}
        <div class="col-lg-4 " id="ingredients-panel">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <input id="ingredient-search" type="text" class="form-control me-2" placeholder="Tìm nguyên liệu..." value="{{ $search ?? '' }}">
                        <button class="btn btn-accent2" id="toggle-panel-mobile" type="button" onclick="toggleIngredientPanel()">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>

                    <div class="mb-3">
                        <select id="ingredient-filter" class="form-select form-select-sm">
                            <option value="">Tất cả loại</option>
                            <option value="protein">Nhiều Protein</option>
                            <option value="carb">Nhiều Carb</option>
                            <option value="fat">Nhiều Fat</option>
                            <option value="vegetable">Rau củ</option>
                            <option value="spice">Gia vị</option>
                        </select>
                    </div>

                    <div class="ingredients-list" style="max-height: 60vh; overflow-y:auto;">
                        @foreach($ingredients as $ingredient)
                            <div class="ingredient-item mb-2 p-2 border rounded d-flex justify-content-between align-items-center"
                                draggable="true"
                                data-id="{{ $ingredient->id }}"
                                data-name="{{ $ingredient->name }}"
                                data-unit="{{ $ingredient->unit }}"
                                data-protein="{{ $ingredient->protein ?? 0 }}"
                                data-carb="{{ $ingredient->carb ?? 0 }}"
                                data-fat="{{ $ingredient->fat ?? 0 }}"
                                data-calories="{{ $ingredient->calo ?? 0 }}">
                                <div>
                                    <strong class="ingredient-name">{{ $ingredient->name }}</strong>
                                    <div class="text-muted"><small>{{ $ingredient->unit }}</small></div>
                                </div>
                                <div class="text-end">
                                    <div><small class="text-primary">{{ $ingredient->calo ?? 0 }} kcal</small></div>
                                    <div class="text-muted"><small>P:{{ $ingredient->protein ?? 0 }} | C:{{ $ingredient->carb ?? 0 }} | F:{{ $ingredient->fat ?? 0 }}</small></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">Kéo thả hoặc double-click để thêm</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Recipe / Calculation --}}
        <div class="col-lg-8">
            <div class="card border-primary shadow-sm" id="recipe-drop-zone" ondrop="drop(event)" ondragover="allowDrop(event)">
                <div class="card-header d-flex justify-content-between align-items-center" style="background:{{ $dark }}; color:white;">
                    <h6 class="mb-0"><i class="bi bi-list-ul"></i> Nguyên liệu đã chọn</h6>
                    <div class="btn-group">
                        <button class="btn btn-outline-light btn-sm me-3" type="button" onclick="toggleIngredientPanel()">
                            <i class="bi bi-basket"></i> Thư viện
                        </button>
                        <button class="btn btn-accent btn-sm" type="button" onclick="clearAllIngredients()">
                            <i class="bi bi-trash"></i> Xóa tất cả
                        </button>
                    </div>
                </div>

                <div class="card-body" style="min-height: 320px;">
                    <div id="ingredients-container">
                        <div class="empty-state text-center text-muted py-4">
                            <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                            <h6>Kéo thả nguyên liệu vào đây</h6>
                            <p class="mb-0">Hoặc double-click nguyên liệu để thêm</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Ghi chú: Giá trị dinh dưỡng tính theo công thức base (per 100g) và điều chỉnh theo số lượng.</small>
                    </div>
                    <div>
                        <button class="btn btn-accent2 btn-sm" onclick="exportSummary()">Xuất kết quả</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS logic --}}
<script>
    // state
    let ingredientIndex = 0;
    let totals = { protein: 0, carb: 0, fat: 0, calo: 0 };

    // Helpers
    function formatNum(v, dec=1) { return (Math.round((v + Number.EPSILON) * Math.pow(10, dec)) / Math.pow(10, dec)).toFixed(dec); }

    document.addEventListener('DOMContentLoaded', () => {
        initIngredientItems();
        initSearchAndFilter();
    });

    /* ---------------- Drag & Drop and Add ---------------- */
    function initIngredientItems() {
        document.querySelectorAll('.ingredient-item').forEach(item => {
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
            });
            item.addEventListener('dragend', function(e) {
                this.style.opacity = '1';
            });

            // double click to add
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
                    toast('Nguyên liệu đã tồn tại', 'warning'); return;
                }
                addRecipeIngredient(payload);
                toast('Đã thêm: ' + payload.name, 'success');
            });
        });
    }

    function allowDrop(ev) { ev.preventDefault(); ev.currentTarget.classList.add('border-3'); }
    function drop(ev) {
        ev.preventDefault();
        ev.currentTarget.classList.remove('border-3');
        let json = ev.dataTransfer.getData('ingredient');
        if (!json) return;
        const payload = JSON.parse(json);
        if (isIngredientExists(payload.id)) {
            toast('Nguyên liệu đã tồn tại', 'warning'); return;
        }
        addRecipeIngredient(payload);
        toast('Đã thêm: ' + payload.name, 'success');
    }

    function isIngredientExists(id) {
        return document.querySelector(`input[name="ingredients[${id}]"]`) !== null;
    }

    /* ---------------- Add row & calculate ---------------- */
    function addRecipeIngredient(data) {
        const container = document.getElementById('ingredients-container');
        // remove empty state
        const empty = container.querySelector('.empty-state');
        if (empty) empty.remove();

        const row = document.createElement('div');
        row.className = 'recipe-ingredient-row mb-3 p-3 border rounded bg-light';
        row.dataset.id = data.id;

        // default quantity 100 (per 100g)
        const quantityDefault = 100;

        row.innerHTML = `
            <div class="row align-items-center gx-2">
                <div class="col-md-5">
                    <strong>${data.name}</strong>
                    <div class="text-muted"><small>${data.unit}</small></div>
                    <input type="hidden" name="ingredients[${data.id}]" value="${data.id}">
                    <input type="hidden" class="base-protein" value="${data.protein}">
                    <input type="hidden" class="base-carb" value="${data.carb}">
                    <input type="hidden" class="base-fat" value="${data.fat}">
                    <input type="hidden" class="base-calories" value="${data.calories}">
                </div>

                <div class="col-md-3">
                    <input type="number" class="form-control quantity-input" value="${quantityDefault}" min="0" step="0.1"
                        onchange="calculateNutrition(this)">
                </div>

                <div class="col-md-3">
                    <div class="nutrition-info small">
                        <div>Calories: <span class="calories">${formatNum((data.calories * quantityDefault)/100,0)}</span> kcal</div>
                        <div>P: <span class="protein">${formatNum((data.protein * quantityDefault)/100,1)}</span>g |
                             C: <span class="carb">${formatNum((data.carb * quantityDefault)/100,1)}</span>g |
                             F: <span class="fat">${formatNum((data.fat * quantityDefault)/100,1)}</span>g</div>
                    </div>
                </div>

                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRecipeIngredient(this)">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(row);
        ingredientIndex++;
        calculateNutrition(row.querySelector('.quantity-input'));
        updateTotalNutrition();

        // animation
        row.style.opacity = 0;
        row.style.transform = 'translateY(-6px)';
        setTimeout(()=> { row.style.transition='all .3s'; row.style.opacity=1; row.style.transform='translateY(0)'; }, 20);
    }

    function removeRecipeIngredient(btn) {
        const row = btn.closest('.recipe-ingredient-row');
        row.style.opacity = 0;
        row.style.transform = 'translateX(30px)';
        setTimeout(()=> {
            row.remove();
            updateTotalNutrition();
            // if empty -> show empty state
            const container = document.getElementById('ingredients-container');
            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="empty-state text-center text-muted py-4">
                        <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                        <h6>Kéo thả nguyên liệu vào đây</h6>
                        <p class="mb-0">Hoặc double-click nguyên liệu để thêm</p>
                    </div>
                `;
            }
        }, 220);
    }

    function clearAllIngredients() {
        const container = document.getElementById('ingredients-container');
        container.innerHTML = `
            <div class="empty-state text-center text-muted py-4">
                <i class="bi bi-arrow-left-right fs-1 d-block mb-2"></i>
                <h6>Kéo thả nguyên liệu vào đây</h6>
                <p class="mb-0">Hoặc double-click nguyên liệu để thêm</p>
            </div>
        `;
        totals = { protein:0, carb:0, fat:0, calo:0 };
        updateTotalsOnUI();
        toast('Đã xóa tất cả nguyên liệu', 'info');
    }

    /* ---------------- Calculate per-row & totals ---------------- */
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

        row.querySelector('.protein').textContent = formatNum(actualP,1);
        row.querySelector('.carb').textContent = formatNum(actualC,1);
        row.querySelector('.fat').textContent = formatNum(actualF,1);
        row.querySelector('.calories').textContent = formatNum(actualCal,0);

        updateTotalNutrition();
    }

    function updateTotalNutrition() {
        const rows = document.querySelectorAll('.recipe-ingredient-row');
        let P=0,C=0,F=0,Cal=0;
        rows.forEach(r => {
            P += parseFloat(r.querySelector('.protein').textContent) || 0;
            C += parseFloat(r.querySelector('.carb').textContent) || 0;
            F += parseFloat(r.querySelector('.fat').textContent) || 0;
            Cal += parseFloat(r.querySelector('.calories').textContent) || 0;
        });
        totals = { protein: P, carb: C, fat: F, calo: Cal };
        updateTotalsOnUI();
    }

    function updateTotalsOnUI() {
        document.getElementById('total-protein').textContent = formatNum(totals.protein,1);
        document.getElementById('total-carb').textContent = formatNum(totals.carb,1);
        document.getElementById('total-fat').textContent = formatNum(totals.fat,1);
        document.getElementById('total-calories').textContent = formatNum(totals.calo,0);
    }

    /* ---------------- Search & Filter ---------------- */
    function initSearchAndFilter() {
        const searchEl = document.getElementById('ingredient-search');
        const filterEl = document.getElementById('ingredient-filter');

        function apply() {
            const q = searchEl.value.trim().toLowerCase();
            const f = filterEl.value;
            filterIngredients(q,f);
        }

        searchEl.addEventListener('input', apply);
        filterEl.addEventListener('change', apply);
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
                if (filter === 'spice') okFilter = /muối|tiêu|gia vị|hành|tỏi|gừng|gừng/i.test(name);
            }
            const show = okSearch && okFilter;
            item.style.display = show ? 'flex' : 'none';
            if (show) visible++;
        });

        // no results
        const list = document.querySelector('.ingredients-list');
        const existing = list.querySelector('.no-results-message');
        if (existing) existing.remove();
        if (visible === 0) {
            const no = document.createElement('div');
            no.className = 'no-results-message text-center py-3';
            no.innerHTML = `<i class="bi bi-search fs-3 d-block mb-2"></i><div>Không tìm thấy nguyên liệu</div>`;
            list.appendChild(no);
        }
    }

    /* ---------------- Utilities (toast & export) ---------------- */
    function toast(msg, type='info') {
        // simple alert fallback - you can replace with nicer toast lib
        console.log(`[${type}] ${msg}`);
    }

    function toggleIngredientPanel() {
        const el = document.getElementById('ingredients-panel');
        if (!el) return;
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }

    function exportSummary() {
        const summary = {
            protein: totals.protein,
            carb: totals.carb,
            fat: totals.fat,
            calories: totals.calo,
            items: Array.from(document.querySelectorAll('.recipe-ingredient-row')).map(r => ({
                id: r.dataset.id,
                name: r.querySelector('strong').textContent,
                quantity: r.querySelector('.quantity-input').value,
                protein: r.querySelector('.protein').textContent,
                carb: r.querySelector('.carb').textContent,
                fat: r.querySelector('.fat').textContent,
                calories: r.querySelector('.calories').textContent
            }))
        };
        const blob = new Blob([JSON.stringify(summary, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = 'nutri-summary.json'; document.body.appendChild(a);
        a.click(); a.remove(); URL.revokeObjectURL(url);
    }
</script>
@endsection
