<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IngredientModel;
use Illuminate\Http\Request;

class NutriController extends Controller
{
    // Hiển thị trang Nutri Calculator
    public function index(Request $request)
    {
        $search = $request->query('search', null);
        // Lấy tất cả nguyên liệu. Có thể paginate nếu danh sách dài.
        $ingredients = IngredientModel::when($search, function ($q, $search) {
            return $q->where('name', 'LIKE', "%{$search}%");
        })->orderBy('name')->get();

        return view('site.nutri-calc', compact('ingredients', 'search'));
    }
}
