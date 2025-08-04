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
        return view('admin.ingredients.form-main', [
            'ingredient' => null
        ]);
    }

    public function edit($id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        return view('admin.ingredients.form-main', [
            'ingredient' => $ingredient
        ]);
    }

    public function save(Request $request)
    {
        // Validate dữ liệu
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
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

    // Các method cũ để tương thích với resource routes (nếu cần)
    public function store(Request $request)
    {
        return $this->save($request);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->save($request);
    }
}
