<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchFillterRequest;
use App\Models\AllergenModel;
use App\Models\DietTypeModel;
use App\Models\MealModel;
use App\Models\MealTypeModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MealsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $controllerName = "meals";
    public $pathViewController = "site.meals.";

    public function index(SearchFillterRequest $request){

        $params = $request->all();

        $search = $params['search'] ?? '';
        
        $mealType = $params['meal_type'] ?? '';
        $caloriesMin = $params['calories_min'] ?? '';
        $caloriesMax = $params['calories_max'] ?? '';
        $allergen = $params['allergen'] ?? '';
        $diet = $params['diet'] ?? '';


        $dietTypes = DietTypeModel::all();
        $mealTypes = MealTypeModel::all();
        $allergens = AllergenModel::all();

        // khởi tạo query  lấy từ model gốc
        $meals = MealModel::with('recipeIngredients.ingredient')
                            ->withSum('recipeIngredients as total_calories', 'total_calo') // Sửa đổi ở đây
                            ->orderBy('id','desc' );

        // Gom điều kiện tìm kiếm thành mảng cho bên hiển thị form k tìm thấy
            $searchConditions = [];

        //Tìm theo tên, nguyên liệu, diet type
        if(!empty($search)){
            $meals = $meals->where(function($query) use ($search){
                $query->where('name','like',"%$search%")
                    ->orwhereHas('ingredients',function($q) use($search){
                        $q->where('name','like',"%$search%");
                    })
                    ->orwhereHas('dietType',function($q) use($search){
                        $q->where('name','like',"%$search%");
                    });
            });
            $searchConditions[] = 'từ khóa " ' . $search. ' "';
        }

        //lọc theo diet
        if(!empty($diet)){
            $dietName = DietTypeModel::find($diet)?->name ?? $diet; // Lấy tên diet từ DB
            $meals = $meals->whereHas('dietType',function($q) use($diet){
                        $q->where('diet_type.id',$diet);
                    });
                if($dietName){
                    $searchConditions[] = 'chế độ ăn " ' . $dietName. ' "';

                }

           
        }

        //lọc theo allergen
        if(!empty($allergen)){
            $allergentName = AllergenModel::find($allergen)?->name ?? $allergen; // Lấy tên diet từ DB
            $meals = $meals->whereHas('allergens',function($q) use($allergen){
                        $q->where('allergens.id',$allergen);
                    });
               if($allergentName){
                    $searchConditions[] = 'chất dị ứng " ' . $allergentName. ' "';

                }

            
        }

        //lọc theo mealtype
        if(!empty($mealType)){
            $mealTypeName = MealTypeModel::find($mealType)?->name ?? $mealType; // Lấy tên diet từ DB
            $meals = $meals->where('meals.meal_type_id',$mealType);
            if($mealTypeName){
                    $searchConditions[] = 'chế độ ăn " ' . $mealTypeName. ' "';

                }
        }

        //lọc theo calories
        if(!empty($caloriesMin )){
            $meals = $meals->having('total_calories','>=',$caloriesMin);
                    
            $searchConditions[] = 'Calories Min " ' . $caloriesMin. ' "';
        }
        if(!empty($caloriesMax)){
            $meals = $meals->having('total_calories','<=',$caloriesMax);
            $searchConditions[] = 'Calories Max " ' . $caloriesMax. ' "';
        }

        // lay du lieu phan trang
        $meals = $meals->paginate(9,'*','meals_page');

        return view($this->pathViewController.'index',[
            'meals'=>$meals,
            'search'=>$search,
            'diet'=>$diet,
            'mealType'=>$mealType,
            'caloriesMin'=>$caloriesMin,
            'caloriesMax'=>$caloriesMax,
            'allergen'=>$allergen,
            'dietTypes'=>$dietTypes,
            'mealTypes'=>$mealTypes,
            'allergens'=> $allergens,
            'searchConditions'=>$searchConditions
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
