<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IngredientRequest;
use App\Models\IngredientModel;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = IngredientModel::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ingredients.index', [
            'ingredients' => $ingredients
        ]);
    }

    public function create()
    {
        return view('admin.ingredients.create');
    }

    public function store(IngredientRequest $request)
    {
        IngredientModel::create($request->validated());
        return redirect()->route('ingredients.index')->with('success', 'Nguyên liệu đã được thêm.');
    }

    public function edit($id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        return view('admin.ingredients.edit', [
            'ingredient' => $ingredient
        ]);
    }

    public function update(IngredientRequest $request, $id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        $ingredient->update($request->validated());
        return redirect()->route('ingredients.index')->with('success', 'Đã cập nhật nguyên liệu.');
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
