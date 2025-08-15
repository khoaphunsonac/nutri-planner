document.addEventListener("DOMContentLoaded", function() {

            // Bỏ dấu tiếng Việt
            function removeVietnameseTones(str) {
                return str.normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "")
                    .replace(/đ/g, "d")
                    .replace(/Đ/g, "D");
            }

            function normalizeText(str) {
                return removeVietnameseTones(str).toLowerCase().trim();
            }

            // Search & Filter
            const searchInput = document.getElementById("ingredient-search");
            const filterSelect = document.getElementById("ingredient-filter");
            const ingredientItems = document.querySelectorAll(".ingredient-item");

            function filterIngredients() {
                const keyword = normalizeText(searchInput.value);
                const filterType = filterSelect.value;

                ingredientItems.forEach(item => {
                    const name = normalizeText(item.querySelector(".ingredient-name").textContent);
                    const protein = parseFloat(item.dataset.protein);
                    const carb = parseFloat(item.dataset.carb);
                    const fat = parseFloat(item.dataset.fat);

                    let matchSearch = keyword === "" || name.includes(keyword);
                    let matchFilter = true;
                    if (filterType === "protein") matchFilter = protein >= carb && protein >= fat;
                    if (filterType === "carb") matchFilter = carb >= protein && carb >= fat;
                    if (filterType === "fat") matchFilter = fat >= protein && fat >= carb;

                    item.style.display = (matchSearch && matchFilter) ? "flex" : "none";
                });
            }

            searchInput.addEventListener("input", filterIngredients);
            filterSelect.addEventListener("change", filterIngredients);

            // Drag & Drop + Double Click
            const recipeContainer = document.getElementById("recipe-container");

            ingredientItems.forEach(item => {
                item.addEventListener("dragstart", function(e) {
                    e.dataTransfer.setData("ingredient", JSON.stringify({
                        id: this.dataset.id,
                        name: this.dataset.name,
                        protein: parseFloat(this.dataset.protein),
                        carb: parseFloat(this.dataset.carb),
                        fat: parseFloat(this.dataset.fat),
                        calories: parseFloat(this.dataset.calories)
                    }));
                });

                item.addEventListener("dblclick", function() {
                    const data = {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        protein: parseFloat(this.dataset.protein),
                        carb: parseFloat(this.dataset.carb),
                        fat: parseFloat(this.dataset.fat),
                        calories: parseFloat(this.dataset.calories)
                    };
                    addIngredientToRecipe(data);
                });
            });

            recipeContainer.addEventListener("dragover", e => e.preventDefault());
            recipeContainer.addEventListener("drop", function(e) {
                e.preventDefault();
                const data = JSON.parse(e.dataTransfer.getData("ingredient"));
                if (data) addIngredientToRecipe(data);
            });

            // Thêm nguyên liệu vào công thức
            function addIngredientToRecipe(data) {
                if (document.querySelector(`[data-row-id="${data.id}"]`)) {
                    alert("Nguyên liệu này đã có!");
                    return;
                }

                const row = document.createElement("div");
                row.className = "d-flex justify-content-between align-items-center border p-2 mb-2";
                row.dataset.rowId = data.id;
                row.dataset.protein = data.protein;
                row.dataset.carb = data.carb;
                row.dataset.fat = data.fat;
                row.dataset.calories = data.calories;

                let qty = 100;
                row.innerHTML = `
            <span>${data.name}</span>
            <div class="d-flex align-items-center">
                <small class="me-3 text-muted nutrition-display">
                    ${getNutritionText(data, qty)}
                </small>
                <input type="number" value="${qty}" min="0" class="form-control form-control-sm quantity-input me-2" style="width:80px;">
                <button class="btn btn-sm btn-danger">&times;</button>
            </div>
        `;

                // Validate input số
                const qtyInput = row.querySelector(".quantity-input");
                qtyInput.addEventListener("input", function() {
                    let val = parseFloat(this.value);
                    if (isNaN(val) || val < 0) {
                        this.value = 0;
                        val = 0;
                    }
                    row.querySelector(".nutrition-display").textContent = getNutritionText(data, val);
                    updateTotals();
                });

                // Xóa nguyên liệu
                row.querySelector("button").addEventListener("click", function() {
                    row.remove();
                    updateTotals();
                });

                recipeContainer.appendChild(row);
                updateTotals();
            }

            // Tính dinh dưỡng hiển thị
            function getNutritionText(data, qty) {
                let p = ((data.protein * qty) / 100).toFixed(1);
                let c = ((data.carb * qty) / 100).toFixed(1);
                let f = ((data.fat * qty) / 100).toFixed(1);
                let cal = ((data.calories * qty) / 100).toFixed(0);
                return `P: ${p}g | C: ${c}g | F: ${f}g | ${cal} kcal`;
            }

            // Cập nhật tổng dinh dưỡng
            function updateTotals() {
                let totalP = 0,
                    totalC = 0,
                    totalF = 0,
                    totalCal = 0;
                document.querySelectorAll("#recipe-container [data-row-id]").forEach(row => {
                    let qty = parseFloat(row.querySelector(".quantity-input").value) || 0;
                    totalP += (parseFloat(row.dataset.protein) * qty) / 100;
                    totalC += (parseFloat(row.dataset.carb) * qty) / 100;
                    totalF += (parseFloat(row.dataset.fat) * qty) / 100;
                    totalCal += (parseFloat(row.dataset.calories) * qty) / 100;
                });
                document.getElementById("total-protein").textContent = totalP.toFixed(1);
                document.getElementById("total-carb").textContent = totalC.toFixed(1);
                document.getElementById("total-fat").textContent = totalF.toFixed(1);
                document.getElementById("total-calories").textContent = totalCal.toFixed(0);
            }

            filterIngredients(); // chạy khi load
        });