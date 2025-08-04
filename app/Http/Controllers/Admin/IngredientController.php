<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Models\IngredientModel;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Danh sách đơn vị cố định
     */
    private function getUnitOptions()
    {
        return [
            'g' => 'Gram (g)',
            'ml' => 'Milliliter (ml)',
            'kg' => 'Kilogram (kg)',
            'l' => 'Liter (l)',
            'piece' => 'Cái',
            'tbsp' => 'Muỗng canh',
            'tsp' => 'Muỗng cà phê',
            'cup' => 'Cốc',
            'slice' => 'Lát',
            'pack' => 'Gói'
        ];
    }

    public function index()
    {
        $ingredients = IngredientModel::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ingredients.index', [
            'ingredients' => $ingredients
        ]);
    }

    public function create()
    {
        return view('admin.ingredients.form-main', [
            'ingredient' => null,
            'unitOptions' => $this->getUnitOptions()
        ]);
    }

    public function edit($id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        return view('admin.ingredients.form-main', [
            'ingredient' => $ingredient,
            'unitOptions' => $this->getUnitOptions()
        ]);
    }

    public function save(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|in:' . implode(',', array_keys($this->getUnitOptions())),
            'protein' => 'required|numeric|min:0',
            'carb' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
        ]);

        $id = $request->input('id');

        if ($id) {
            // Cập nhật ingredient có sẵn
            $ingredient = IngredientModel::findOrFail($id);
            $ingredient->update($validatedData);
            return redirect()->route('ingredients.index')->with('success', 'Đã cập nhật nguyên liệu.');
        } else {
            // Tạo ingredient mới
            IngredientModel::create($validatedData);
            return redirect()->route('ingredients.index')->with('success', 'Nguyên liệu đã được thêm.');
        }
    }

    public function show($id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        return view('admin.ingredients.show', [
            'ingredient' => $ingredient
        ]);
    }

    public function destroy($id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success', 'Đã xóa nguyên liệu.');
    }
}
