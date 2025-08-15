// JavaScript for interactions
document.addEventListener("DOMContentLoaded", function () {
    initIngredientItems();
    initSearchAndFilter();
});

function initIngredientItems() {
    document.querySelectorAll(".ingredient-item").forEach((item) => {
        // Drag events
        item.addEventListener("dragstart", function (e) {
            const data = {
                id: this.dataset.id,
                name: this.dataset.name,
                unit: this.dataset.unit,
                protein: parseFloat(this.dataset.protein) || 0,
                carb: parseFloat(this.dataset.carb) || 0,
                fat: parseFloat(this.dataset.fat) || 0,
                calories: parseFloat(this.dataset.calories) || 0,
            };
            e.dataTransfer.setData("ingredient", JSON.stringify(data));
            this.style.opacity = "0.5";
        });

        item.addEventListener("dragend", function () {
            this.style.opacity = "1";
        });

        // Double click to add
        item.addEventListener("dblclick", function () {
            const data = {
                id: this.dataset.id,
                name: this.dataset.name,
                unit: this.dataset.unit,
                protein: parseFloat(this.dataset.protein) || 0,
                carb: parseFloat(this.dataset.carb) || 0,
                fat: parseFloat(this.dataset.fat) || 0,
                calories: parseFloat(this.dataset.calories) || 0,
            };
            addIngredientToRecipe(data);
        });
    });
}

function initSearchAndFilter() {
    const searchInput = document.getElementById("ingredient-search");
    const filterSelect = document.getElementById("ingredient-filter");

    searchInput.addEventListener("input", function () {
        filterIngredients();
    });

    filterSelect.addEventListener("change", function () {
        filterIngredients();
    });
}

function filterIngredients() {
    const searchTerm = document
        .getElementById("ingredient-search")
        .value.toLowerCase();
    const filterValue = document.getElementById("ingredient-filter").value;

    document.querySelectorAll(".ingredient-item").forEach((item) => {
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
                case "protein":
                    show = show && protein >= Math.max(carb, fat);
                    break;
                case "carb":
                    show = show && carb >= Math.max(protein, fat);
                    break;
                case "fat":
                    show = show && fat >= Math.max(protein, carb);
                    break;
            }
        }

        item.style.display = show ? "block" : "none";
    });
}

function allowDrop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.add("drag-over");
}

function drop(ev) {
    ev.preventDefault();
    ev.currentTarget.classList.remove("drag-over");

    const ingredientData = JSON.parse(ev.dataTransfer.getData("ingredient"));
    addIngredientToRecipe(ingredientData);
}

function addIngredientToRecipe(data) {
    const container = document.getElementById("recipe-container");

    // Remove empty state if exists
    const emptyState = container.querySelector(".empty-state");
    if (emptyState) {
        emptyState.remove();
    }

    // Check if ingredient already exists
    if (document.querySelector(`[data-recipe-id="${data.id}"]`)) {
        showNotification("Nguyên liệu đã có trong công thức!", "warning");
        return;
    }

    const ingredientRow = document.createElement("div");
    ingredientRow.className = "recipe-ingredient";
    ingredientRow.setAttribute("data-recipe-id", data.id);

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
    showNotification(`Đã thêm ${data.name} vào công thức`, "success");
}

function updateNutrition(input, baseProtein, baseCarb, baseFat, baseCalories) {
    const quantity = parseFloat(input.value) || 0;
    const row = input.closest(".recipe-ingredient");

    const calories = ((baseCalories * quantity) / 100).toFixed(0);
    const protein = ((baseProtein * quantity) / 100).toFixed(1);
    const carb = ((baseCarb * quantity) / 100).toFixed(1);
    const fat = ((baseFat * quantity) / 100).toFixed(1);

    row.querySelector(".calories").textContent = calories;
    row.querySelector(".protein").textContent = protein + "g";
    row.querySelector(".carb").textContent = carb + "g";
    row.querySelector(".fat").textContent = fat + "g";

    updateTotalNutrition();
}

function updateTotalNutrition() {
    const ingredients = document.querySelectorAll(".recipe-ingredient");
    let totalCalories = 0,
        totalProtein = 0,
        totalCarb = 0,
        totalFat = 0;

    ingredients.forEach((ingredient) => {
        totalCalories +=
            parseFloat(ingredient.querySelector(".calories").textContent) || 0;
        totalProtein +=
            parseFloat(
                ingredient
                    .querySelector(".protein")
                    .textContent.replace("g", "")
            ) || 0;
        totalCarb +=
            parseFloat(
                ingredient.querySelector(".carb").textContent.replace("g", "")
            ) || 0;
        totalFat +=
            parseFloat(
                ingredient.querySelector(".fat").textContent.replace("g", "")
            ) || 0;
    });

    document.getElementById("total-calories").textContent =
        totalCalories.toFixed(0);
    document.getElementById("total-protein").textContent =
        totalProtein.toFixed(1);
    document.getElementById("total-carb").textContent = totalCarb.toFixed(1);
    document.getElementById("total-fat").textContent = totalFat.toFixed(1);
}

function removeIngredient(button) {
    const row = button.closest(".recipe-ingredient");
    row.remove();
    updateTotalNutrition();

    // Add empty state if no ingredients
    const container = document.getElementById("recipe-container");
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

    showNotification("Đã xóa nguyên liệu", "info");
}

function clearAllIngredients() {
    if (confirm("Bạn có chắc chắn muốn xóa tất cả nguyên liệu?")) {
        const container = document.getElementById("recipe-container");
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
        showNotification("Đã xóa tất cả nguyên liệu", "info");
    }
}

function showNotification(message, type = "info") {
    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
    toast.style.position = "fixed";
    toast.style.top = "20px";
    toast.style.right = "20px";
    toast.style.zIndex = "9999";

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
    const ingredients = document.querySelectorAll(".recipe-ingredient");

    // Kiểm tra có nguyên liệu không
    if (ingredients.length === 0) {
        showNotification("Chưa có nguyên liệu nào để xuất!", "warning");
        return;
    }

    // Tạo dữ liệu cho Excel
    const data = [];

    // Header
    data.push([
        "STT",
        "Tên nguyên liệu",
        "Khối lượng",
        "Đơn vị",
        "Calories (kcal)",
        "Protein (g)",
        "Carb (g)",
        "Fat (g)",
    ]);

    // Thêm dữ liệu nguyên liệu
    ingredients.forEach((ingredient, index) => {
        const name = ingredient.querySelector("h6").textContent;
        const unit = ingredient.querySelector("small").textContent;
        const quantity = ingredient.querySelector('input[type="number"]').value;
        const calories = ingredient.querySelector(".calories").textContent;
        const protein = parseFloat(
            ingredient.querySelector(".protein").textContent.replace("g", "")
        );
        const carb = parseFloat(
            ingredient.querySelector(".carb").textContent.replace("g", "")
        );
        const fat = parseFloat(
            ingredient.querySelector(".fat").textContent.replace("g", "")
        );

        data.push([
            index + 1,
            name,
            quantity,
            unit,
            parseFloat(calories),
            protein,
            carb,
            fat,
        ]);
    });

    // Thêm dòng trống
    data.push(["", "", "", "", "", "", "", ""]);

    // Thêm tổng kết
    const totalCalories = document.getElementById("total-calories").textContent;
    const totalProtein = document.getElementById("total-protein").textContent;
    const totalCarb = document.getElementById("total-carb").textContent;
    const totalFat = document.getElementById("total-fat").textContent;

    data.push([
        "",
        "TỔNG CỘNG",
        "",
        "",
        parseFloat(totalCalories),
        parseFloat(totalProtein),
        parseFloat(totalCarb),
        parseFloat(totalFat),
    ]);

    // Thêm thông tin bổ sung
    data.push(["", "", "", "", "", "", "", ""]);
    data.push(["Thông tin bổ sung:", "", "", "", "", "", "", ""]);
    data.push([
        "Ngày tạo:",
        new Date().toLocaleDateString("vi-VN"),
        "",
        "",
        "",
        "",
        "",
        "",
    ]);
    data.push([
        "Thời gian:",
        new Date().toLocaleTimeString("vi-VN"),
        "",
        "",
        "",
        "",
        "",
        "",
    ]);
    data.push(["Tạo bởi:", "Nutri-Planner Calculator", "", "", "", "", "", ""]);

    // Tạo workbook và worksheet
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(data);

    // Styling cho Excel
    const range = XLSX.utils.decode_range(ws["!ref"]);

    // Auto-fit columns
    const colWidths = [
        {
            wch: 5,
        }, // STT
        {
            wch: 25,
        }, // Tên nguyên liệu
        {
            wch: 12,
        }, // Khối lượng
        {
            wch: 10,
        }, // Đơn vị
        {
            wch: 15,
        }, // Calories
        {
            wch: 12,
        }, // Protein
        {
            wch: 12,
        }, // Carb
        {
            wch: 12,
        }, // Fat
    ];
    ws["!cols"] = colWidths;

    // Merge cells cho tiêu đề "TỔNG CỘNG"
    if (!ws["!merges"]) ws["!merges"] = [];

    // Style cho header
    for (let col = 0; col <= 7; col++) {
        const cellAddr = XLSX.utils.encode_cell({
            r: 0,
            c: col,
        });
        if (!ws[cellAddr]) continue;
        ws[cellAddr].s = {
            font: {
                bold: true,
                color: {
                    rgb: "FFFFFF",
                },
            },
            fill: {
                fgColor: {
                    rgb: "17A2B8",
                },
            },
            alignment: {
                horizontal: "center",
                vertical: "center",
            },
        };
    }

    // Style cho dòng tổng cộng
    const totalRowIndex = data.length - 5; // Vị trí dòng "TỔNG CỘNG"
    for (let col = 0; col <= 7; col++) {
        const cellAddr = XLSX.utils.encode_cell({
            r: totalRowIndex,
            c: col,
        });
        if (!ws[cellAddr]) continue;
        ws[cellAddr].s = {
            font: {
                bold: true,
            },
            fill: {
                fgColor: {
                    rgb: "F8F9FA",
                },
            },
            border: {
                top: {
                    style: "thick",
                },
                bottom: {
                    style: "thick",
                },
            },
        };
    }

    // Thêm worksheet vào workbook
    XLSX.utils.book_append_sheet(wb, ws, "Nutrition Calculator");

    // Tạo tên file với timestamp
    const now = new Date();
    const timestamp = now
        .toISOString()
        .slice(0, 19)
        .replace(/[:-]/g, "")
        .replace("T", "_");
    const filename = `nutrition_calculator_${timestamp}.xlsx`;

    // Xuất file
    try {
        XLSX.writeFile(wb, filename);
        showNotification("Đã xuất file Excel thành công!", "success");
    } catch (error) {
        console.error("Lỗi khi xuất file:", error);
        showNotification("Có lỗi xảy ra khi xuất file!", "danger");
    }
}
