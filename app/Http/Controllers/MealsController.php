<?php

namespace App\Http\Controllers;

use App\Models\MealModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MealsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $controllerName = "meals";
    public $pathViewController = "site.meals.";

    public function index(Request $request){
        $params = $request->all();
        $search = $params['search'] ?? '';
        $tab  = $params['tab'] ?? 'thuc-don';
        $mealType = $params['meal_type'] ?? '';

        
        // khởi tạo query  lấy từ model gốc
        $meals = MealModel::with('recipeIngredients.ingredient')->orderBy('id','desc');
        //lọc theo tên
        if(!empty($search)){
            $meals = $meals->where('name','like',"%$search%");
        }
        //lọc theo meal
        if(!empty($mealType)){
            $meals = $meals->where('meal_type_id','like',"%$mealType%");
        }


        

        // lay du lieu phan trang
        $meals = $meals->paginate(9,'*','meals_page');

        return view($this->pathViewController.'index',[
            'meals'=>$meals,
            'search'=>$search,
            'tab'=>$tab,
        ]);
    }

    public function show($id){
        $meal = MealModel::with(['tags',
                                'mealType',
                                'ingredients',
                                'allergens',
                                'recipeIngredients.ingredient', // lấy nguyên liệu qua bảng trung gian
                            ])->findOrFail($id);
        // lấy 8 món mới nhất (k có món đang xem)
        $latestMeals = MealModel::where('id','!=',$id)
                                ->orderBy('created_at','desc')
                                ->take(8)
                                ->get();

        return view($this->pathViewController.'show',[
            'meal'=>$meal,
            'latestMeals'=>$latestMeals,
        ]);
    }
}
