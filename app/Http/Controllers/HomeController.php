<?php

namespace App\Http\Controllers;

use App\Models\MealModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class HomeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public $viewPath = 'site.home.';
    public function index(){
        $latestMeals = MealModel::with(['tags',
                                'mealType',
                                'ingredients',
                                'allergens',
                                'recipeIngredients.ingredient', // lấy nguyên liệu qua bảng trung gian
                            ])->orderBy('created_at','desc')
                                ->take(8)
                                ->get();
        return view($this->viewPath.'index',[
            'latestMeals'=> $latestMeals
        ]);
    }
}
