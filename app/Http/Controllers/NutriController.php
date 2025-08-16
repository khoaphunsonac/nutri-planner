<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IngredientModel;

class NutriController extends Controller
{
    public function index()
    {
        // Lấy tất cả nguyên liệu từ DB (chỉ lấy các field cần)
        $ingredients = IngredientModel::select('id', 'name', 'unit', 'protein', 'carb', 'fat')
            ->orderBy('name')
            ->get()
            ->map(function ($item) {
                $item->calories = round(($item->protein * 4) + ($item->carb * 4) + ($item->fat * 9), 1);
                return $item;
            });

        return view('site.nutri-calc', [
            'ingredients' => $ingredients
        ]);
    }
}
