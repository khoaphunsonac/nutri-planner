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
        $mealType = $params['mealType'] ?? '';
        $tab  = $params['tab'] ?? 'thuc-don';
        if ($tab === 'thuc-don') {
            $data = MealModel::where('meal_type_id', 1)->get();
        } elseif ($tab === 'tags') {
            $data = MealModel::with('tags')->get();
        } elseif ($tab === 'allergens') {
            $data = MealModel::with('allergens')->get();
        } else {
            $data = [];
        }
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

        $mealTypeNames = [
            1 => 'Bữa sáng',
            2 => 'Bữa trưa',
            3 => 'Bữa chiều',
            4 => 'Bữa tối',
            5 => 'Bữa khuya',
            6 => 'Bữa ăn nhẹ',
            7 => 'Sinh tố'
        ];

        $mealTypeName = $mealTypeNames[$mealType] ?? '';

        // lay du lieu phan trang
        $meals = $meals->paginate(9,'*','meals_page');

        return view($this->pathViewController.'index',[
            'meals'=>$meals,
            'search'=>$search,
            'mealType'=>$mealType,
            'tab'=>$tab,
            'data'=>$data,
            'mealTypeName'=>$mealTypeName,
        ]);
    }

    public function show($id){
        $meal = MealModel::with(['tags',
                                'mealType',
                                'ingredients',
                                'allergens',
                                'recipeIngredients.ingredient', // lấy nguyên liệu qua bảng trung gian
                            ])->findOrFail($id);
        

        return view($this->pathViewController.'show',[
            'meal'=>$meal,
        ]);
    }
}
