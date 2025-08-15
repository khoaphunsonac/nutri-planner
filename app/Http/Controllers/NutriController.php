<?php

namespace App\Http\Controllers;

use App\Models\IngredientModel;
use Illuminate\Http\Request;

class NutriController extends Controller
{
    /**
     * Nutrition Calculator Page
     */
    public function index()
    {
        // Lấy nguyên liệu từ DB và tính calo qua accessor getCaloAttribute
        $ingredients = IngredientModel::select('id', 'name', 'unit', 'protein', 'carb', 'fat')
            ->orderBy('name')
            ->get()
            ->map(function ($item) {
                $item->calo = $item->calo; // Accessor tính calo
                return $item;
            });

        return view('site.nutri-calc', [
            'ingredientsJson' => $ingredients->toJson()
        ]);
    }
}
