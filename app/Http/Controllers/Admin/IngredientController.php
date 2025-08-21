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
            'gram' => 'Gram (g)',
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

    public function index(Request $request)
    {
        // Get search parameter
        $search = $request->get('search');

        // Build query
        $query = IngredientModel::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('id', $search);
        }

        // Get paginated results
        $ingredients = $query->orderBy('id', 'desc')->paginate(10);

        // Preserve search in pagination links
        $ingredients->appends(['search' => $search]);

        // Calculate statistics
        $totalIngredients = IngredientModel::count();
        $activeIngredients = IngredientModel::whereNull('deleted_at')->count();
        $usageRate = $totalIngredients > 0 ? round(($activeIngredients / $totalIngredients) * 100) : 0;
        return view('admin.ingredients.index', [
            'ingredients' => $ingredients,
            'search' => $search,
            'totalIngredients' => $totalIngredients,
            'activeIngredients' => $activeIngredients,
            'usageRate' => $usageRate . '%'
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

    public function save(IngredientRequest $request)
    {
        // Dữ liệu đã được validate tự động bởi IngredientRequest
        $validatedData = $request->validated();

        $id = $request->input('id');

        if ($id) {
            // Cập nhật ingredient có sẵn
            $ingredient = IngredientModel::findOrFail($id);
            $ingredient->update($validatedData);
            return redirect()->route('ingredients.index')->with('success', 'Đã cập nhật nguyên liệu thành công.');
        } else {
            // Tạo ingredient mới
            IngredientModel::create($validatedData);
            return redirect()->route('ingredients.index')->with('success', 'Thêm nguyên liệu mới thành công.');
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
