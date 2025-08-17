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
                $meals = $meals->havingRaw('COALESCE(total_calories, 0) >= ?',[(int)$caloriesMin]);
            }
            if($caloriesMax !== null){
                $meals = $meals->havingRaw('COALESCE(total_calories, 0) <= ?',[(int)$caloriesMax]);
                
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

        $saved = false;
        $favoriteCount = 0;
        if (auth()->check()) {
            $savedMeals = auth()->user()->savemeal ? explode('-', auth()->user()->savemeal) : [];
            $saved = in_array($meal->id, $savedMeals);
            $favoriteCount = count($savedMeals);
        }

        return view($this->pathViewController.'show',[
            'meal'=>$meal,
            'latestMeals'=>$latestMeals,
            'saved'=>$saved,
            'favoriteCount' => $favoriteCount,
        ]);
    }

    

    public function favorite($id){
    
        // ktra dn
        $user = auth()->user();
        // lay tai khoan
        $account = AccountModel::find($user->id); // lấy user đang đăng nhập
       

        // Lấy danh sách meal ID đã lưu (nếu rỗng thì mảng trống)
        $savedMeals  = [];

        if (!empty($account->savemeal)) {
            $savedMeals = explode('-', $account->savemeal);
            // loại bỏ phần tử rỗng nếu có = cách duyệt mảng
            $cleanMeals = [];
            foreach ($savedMeals as $meal) {
                if ($meal !== '' && $meal !== null) {
                    $cleanMeals[] = $meal;
                }
            }
            $savedMeals  = $cleanMeals;
        } 
        // ktra meal co trong danh sach chua
        $found = false;
        foreach($savedMeals as $key => $mealId){
            if($mealId == $id){
                unset($savedMeals[$key]);
                $found = true;
                break;
            }
        }
        // nếu k có thì thêm vào 
        if(!$found){
            // $savedMeals[] = $id;
            array_unshift($savedMeals, $id); // Thêm vào đầu mảng
        }

        // Ghép mảng lại thành chuỗi 1-2-3
        $account->savemeal = implode('-', $savedMeals);
        $account->save();

        return response()->json([
            'status'  => 'success',
            'saved'   => !$found, // true nếu vừa thêm, false nếu vừa gỡ
            'favoriteCount' => count($savedMeals), // QUAN TRỌNG: trả về số lượng mới 'mealId' => $id // Thêm ID món ăn để frontend xử lý
            'mealId' => $id
        ]);

        
    
    }


    public function showsavemeals(){
        $account = auth()->user(); // lấy user đang đăng nhập
        if (!$account) {
            return redirect()->route('home')->with('error', 'Tài khoản không tồn tại');
        }
        // tách chuỗi thành mảng
        $savedMealIds = $account->savemeal ? explode('-', $account->savemeal) : [];

        // lấy dữ liệu các meal theo ID
        $meals = !empty($savedMealIds) 
        ? MealModel::whereIn('id', $savedMealIds)->get() 
        : [];

        return view($this->pathViewController.'showsavemeals',[
                'meals'=>$meals,
                'favoriteCount' => count($savedMealIds),
                "status"=>"success",
                "saved"=>true, // hoặc false nếu bỏ like,
                "message"=>"Thông báo thành công",
            ]); 
    }
}