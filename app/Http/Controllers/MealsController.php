<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchFillterRequest;
use App\Models\AccountModel;
use App\Models\AllergenModel;
use App\Models\DietTypeModel;
use App\Models\MealModel;
use App\Models\MealTypeModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class MealsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $controllerName = "meals";
    public $pathViewController = "site.meals.";

    public function index(SearchFillterRequest $request){

        $params = $request->all();

        $search = $params['search'] ?? '';
        
        $mealType = $params['meal_type'] ?? '';
        $caloriesRange = $params['calories_range'] ?? '';
        $allergen = $params['allergen'] ?? '';
        $diet = $params['diet'] ?? '';


        $dietTypes = DietTypeModel::all();
        $mealTypes = MealTypeModel::all();
        $allergens = AllergenModel::all();

        // khởi tạo query  lấy từ model gốc
        $meals = MealModel::with('recipeIngredients.ingredient')
                            ->withSum('recipeIngredients as total_calories', 'total_calo') // Sum calo ở đây
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

        //lọc bỏ allergen  lấy món không có allergen
        if(!empty($allergen)){
            $allergenName = AllergenModel::find($allergen)?->name ?? $allergen; 
            $meals = $meals->whereDoesntHave('allergens',function($q) use($allergen){ 
                        $q->where('allergens.id',$allergen);
                    });
               if($allergenName){
                    $searchConditions[] = 'loại bỏ món có chất dị ứng " ' . $allergenName. ' "';

                }

            
        }

        //lọc theo mealtype
        if(!empty($mealType)){
            $mealTypeName = MealTypeModel::find($mealType)?->name ?? $mealType; 
            $meals = $meals->where('meals.meal_type_id',$mealType);
            if($mealTypeName){
                    $searchConditions[] = 'chế độ ăn " ' . $mealTypeName. ' "';

                }
        }

        //lọc theo calories
        if(!empty($caloriesRange )){
            // tách chuỗi "min-max"
            [$caloriesMin,$caloriesMax] = explode('-', $caloriesRange) + [null,null];

            if($caloriesMin !== null){
                $meals = $meals->having('total_calories','>=',(int)$caloriesMin);
            }
            if($caloriesMax !== null){
                $meals = $meals->having('total_calories','<=',(int)$caloriesMax);
                
            }
            $searchConditions[] = 'Calories (đơn vị Kcal) từ ' . $caloriesMin. ' đến ' . $caloriesMax;
        }
        // lay du lieu phan trang
        $meals = $meals->paginate(9,'*','meals_page');

        return view($this->pathViewController.'index',[
            'meals'=>$meals,
            'search'=>$search,
            'diet'=>$diet,
            'mealType'=>$mealType,
            'caloriesRange'=>$caloriesRange,
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
        $latestMeals = MealModel::with(['tags',
                                'mealType',
                                'ingredients',
                                'allergens',
                                'recipeIngredients.ingredient', // lấy nguyên liệu qua bảng trung gian
                            ])->where('id','!=',$id)
                                ->orderBy('created_at','desc')
                                ->take(8)
                                ->get();

        return view($this->pathViewController.'show',[
            'meal'=>$meal,
            'latestMeals'=>$latestMeals,
        ]);
    }

    public function favorite($id){
        // //lấy user hiện tại
        // // $user = auth()->user();

        //lấy meal
        $meal =  MealModel::findOrFail($id);

        //lấy giá trị hiện tại từ cột savemeal(chuyển thành mảng)
        $saveMeals = $meal->savemeal ? explode('-',$meal->savemeal) : [];

        // ktra id đã có chưa
        $found = false;
        foreach($saveMeals as $saveId){
            if($saveId == $id){
                $found = true;
                break;
            }
        }
        if($found){
           // nếu id tồn tại thì xóa bằng cách tạo mảng mới k chứa $id
           $newMeals = [];
           foreach($saveMeals as $saveId){
            if($saveId != $id){
                $newMeals[] = $saveId;
            }
           }
           $saveMeals = $newMeals;
        }else{
            //chưa có thì thêm vào
            $saveMeals[] = $id;
        }

        // chuyen mảng thành chuỗi
        $meal->savemeal = implode('-',$saveMeals);
        $meal->save();


        // if (Auth::check()) {
        //     // --- Có user đăng nhập: lưu vào DB ---
        //     $favorite = AccountModel::where('user_id', Auth::id())
        //                         ->where('meal_id', $id)
        //                         ->first();

        //     if ($favorite) {
        //         $favorite->delete(); // Bỏ yêu thích
        //     } else {
        //         AccountModel::create([
        //             'user_id' => Auth::id(),
        //             'meal_id' => $$id
        //         ]);
        //     }
        // } else {
        //     // --- Chưa đăng nhập: lưu vào Session ---
        //     $saveMeals = session('saveMeals', []);

        //     if (in_array($id, $saveMeals)) {
        //         $saveMeals = array_filter($saveMeals, fn($id) => $id != $id);
        //     } else {
        //         $saveMeals[] = $id;
        //     }

        //     session(['saveMeals' => $saveMeals]);
        // // }

        return back();

        
    }
}