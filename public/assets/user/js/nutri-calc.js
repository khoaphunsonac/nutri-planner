document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("ingredient-search");
    const filterSelect = document.getElementById("ingredient-filter");
    const ingredientsList = document.getElementById("ingredients-list");
    const dropzone = document.getElementById("recipe-dropzone");

    let recipe = [];

    function renderIngredients(list) {
        ingredientsList.innerHTML = "";
        list.forEach(ing => {
            const item = document.createElement("div");
            item.className = "ingredient-item border p-2 mb-2";
            item.draggable = true;
            item.dataset.id = ing.id;
            item.dataset.name = ing.name;
            item.dataset.unit = ing.unit;
            item.dataset.protein = ing.protein;
            item.dataset.carb = ing.carb;
            item.dataset.fat = ing.fat;
            item.dataset.calo = ing.calo;

            item.innerHTML = `<strong>${ing.name}</strong> (${ing.unit})<br>
                P:${ing.protein}g | C:${ing.carb}g | F:${ing.fat}g | Cal:${ing.calo}`;

            item.addEventListener("dragstart", e => {
                e.dataTransfer.setData("ingredient", JSON.stringify(ing));
            });

            ingredientsList.appendChild(item);
        });
    }

    function filterIngredients() {
        const keyword = removeVietnameseTones(searchInput.value.toLowerCase().trim());
        const filter = filterSelect.value;

        let filtered = ingredients.filter(ing => 
            removeVietnameseTones(ing.name.toLowerCase()).includes(keyword)
        );

        if (filter) {
            filtered = filtered.filter(ing => {
                if (filter === "protein") return ing.protein >= ing.carb && ing.protein >= ing.fat;
                if (filter === "carb") return ing.carb >= ing.protein && ing.carb >= ing.fat;
                if (filter === "fat") return ing.fat >= ing.protein && ing.fat >= ing.carb;
                return true;
            });
        }

        renderIngredients(filtered);
    }

    function removeVietnameseTones(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/đ/g, "d").replace(/Đ/g, "D");
    }

    function updateTotals() {
        const totals = recipe.reduce((acc, ing) => {
            acc.protein += (ing.protein * ing.qty) / 100;
            acc.carb += (ing.carb * ing.qty) / 100;
            acc.fat += (ing.fat * ing.qty) / 100;
            acc.calo += (ing.calo * ing.qty) / 100;
            return acc;
        }, { protein: 0, carb: 0, fat: 0, calo: 0 });

        document.getElementById("total-protein").textContent = totals.protein.toFixed(1);
        document.getElementById("total-carb").textContent = totals.carb.toFixed(1);
        document.getElementById("total-fat").textContent = totals.fat.toFixed(1);
        document.getElementById("total-calories").textContent = totals.calo.toFixed(0);
    }

    dropzone.addEventListener("dragover", e => e.preventDefault());
    dropzone.addEventListener("drop", e => {
        e.preventDefault();
        const ing = JSON.parse(e.dataTransfer.getData("ingredient"));
        ing.qty = 100;
        recipe.push(ing);
        renderRecipe();
        updateTotals();
    });

    function renderRecipe() {
        dropzone.innerHTML = "";
        recipe.forEach((ing, index) => {
            const row = document.createElement("div");
            row.className = "border p-2 mb-2";
            row.innerHTML = `<strong>${ing.name}</strong> - 
                <input type="number" value="${ing.qty}" min="0" step="0.1" style="width:80px;"> ${ing.unit}
                <button class="btn btn-sm btn-danger float-end">X</button>`;
            
            row.querySelector("input").addEventListener("input", e => {
                ing.qty = parseFloat(e.target.value) || 0;
                updateTotals();
            });

            row.querySelector("button").addEventListener("click", () => {
                recipe.splice(index, 1);
                renderRecipe();
                updateTotals();
            });

            dropzone.appendChild(row);
        });
    }

    document.getElementById("export-excel").addEventListener("click", () => {
        const data = recipe.map(ing => ({
            Name: ing.name,
            Quantity: ing.qty,
            Unit: ing.unit,
            Protein: ((ing.protein * ing.qty) / 100).toFixed(1),
            Carb: ((ing.carb * ing.qty) / 100).toFixed(1),
            Fat: ((ing.fat * ing.qty) / 100).toFixed(1),
            Calories: ((ing.calo * ing.qty) / 100).toFixed(0)
        }));

        const ws = XLSX.utils.json_to_sheet(data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Nutrition");
        XLSX.writeFile(wb, "nutrition_calculator.xlsx");
    });

    searchInput.addEventListener("input", filterIngredients);
    filterSelect.addEventListener("change", filterIngredients);

    renderIngredients(ingredients);
});
