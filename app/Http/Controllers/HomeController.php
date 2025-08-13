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
        $latestMeals = MealModel::with('recipeIngredients.ingredient')
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
        return view($this->viewPath.'index',[
            'latestMeals'=> $latestMeals
        ]);
    }
}
