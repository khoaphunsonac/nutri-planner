<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AllergenRequest;
use App\Models\AllergenModel;
use Carbon\Carbon;
use App\Models\MealModel;
use App\Models\MealAllergenModel;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request ;
use Illuminate\Routing\Controller as BaseController;

use function PHPUnit\Framework\isEmpty;

class AllergenController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $controllerName = "allergens";
    public $pathViewController = "admin.allergens.";

    //================Allergen CRUD================
    public function index(Request $request){
        $id = $request->id;
        // Phần "Tổng quan" - luôn lấy 10 món mới nhất, không bị ảnh hưởng bởi search
        $meals = MealModel::with('allergens')->latest()->take(10)->get();
        $mealAllergens = MealAllergenModel::with(['meal','allergen'])->get();
        $allergen = AllergenModel::all();
        
        $params = $request->all();
        $search = $params['search'] ?? '';
        $query = AllergenModel::withCount('meals')->with('meals');
        $mealSearch = $params['mealSearch'] ?? '';
        $allergenSearch = $params['allergenSearch'] ?? '';
        // Truy vấn Mapping có kèm điều kiện lọc
        $mappingQuery = MealAllergenModel::with(['meal', 'allergen'])->orderBy('id', 'desc');

        $query = AllergenModel::with(['meals'])->withCount('meals');
        $item = null;
       
        if($mealSearch){
             $query = $query->whereHas('meals', function ($query) use($mealSearch) { $query->where('name', 'like', "%$mealSearch%");});
        };
        if($allergenSearch){
            // $query = $query->whereHas('allergen', function ($query) use($allergenSearch) { $query->where('name', 'like', "%$allergenSearch%");});
             $query = $query->where('name','like',"%$allergenSearch%");
        };

        $totalMealsModel = MealModel::count();
        $totalAllergenWithTrashed = AllergenModel::withTrashed()->get();
        // $totalAllergenWithTrashedCount = AllergenModel::withTrashed()->count();
       
        // tổng số tag
        $totalAllergens = count($totalAllergenWithTrashed);
        
        // đếm số tag đang hoạt động
        $activeAllergens = 0;
        //  chưa lọc được tag bị xóa, đặt cứng
        $deletedAllergens = 0;
        //lập qua all tag để đém trạng thái
        foreach($totalAllergenWithTrashed as $allergen){
            if($allergen['deleted_at'] === null){
                $activeAllergens++ ;
            }else{
                $deletedAllergens++ ;
            }
        }
        
        $totalMeals = $meals->count();// Sẽ luôn là 10 hoặc ít hơn nếu không đủ
        // $totalMappings = count($mealAllergens);
        $usageRate =  $totalAllergens > 0 ? round(($activeAllergens/$totalAllergens) *100) . '%' : '0%';

        // Phần "Danh sách Dị ứng" - có pagination và search
        $item = $query->orderBy('id','desc')->paginate(10 );
        // Clone để đếm số mục sau lọc
        $totalMappings = MealAllergenModel::count();
        //  return $item;
        // Tính chỉ số bắt đầu đếm ngược (số lớn nhất trên trang hiện tại)
        $total = $item->total();
        $perPage = $item->perPage();
        $currentPage = $item->currentPage();
        $startIndex = $total - ($currentPage - 1) * $perPage;

        // Thêm phần lấy danh sách món ăn phân trang cho modal
        $mealsForModal = MealModel::query()->paginate(10); // Phân trang 10 món ăn mỗi trang
        return view($this->pathViewController.'index',[
            'allergen'=> $allergen,
            'meals'=>$meals,
            'mealAllergens'=>$mealAllergens,
            'totalAllergenWithTrashed'=>$totalAllergenWithTrashed,
            'totalAllergens'=>$totalAllergens,
            'activeAllergens'=>$activeAllergens,
            'deletedAllergens'=>$deletedAllergens,
            'totalMeals'=>$totalMeals,
            'totalMealsModel'=>$totalMealsModel,
            'totalMappings'=>$totalMappings,
            'usageRate' =>$usageRate,
            'search'=>$search,
            'item'=>$item,
            'mealSearch'=>$mealSearch,
            'allergenSearch'=>$allergenSearch,
            'startIndex'=>$startIndex,
            'totalMeals'=>$totalMeals,
            'mealsForModal'=>$mealsForModal,
        ]);
    }

    public function show($id){
         $allergen = AllergenModel::findOrFail($id);
         $items = AllergenModel::with(['meals.mealType'])->findOrFail($id);
        return view($this->pathViewController.'show',[
            'items'=>$items,
            'item'=>$allergen,
        ]);
    }

    public function form(Request $request){
        $id=$request->id;
         $item = $id ? AllergenModel::with('meals')->findOrFail($id) : null;
         // lay ds mon an co phan trang
         $meals = MealModel::orderBy('name','asc')->paginate(20,['*'],'meals_page');

         //neu dang edit lay mang ID mon an da duoc gan
         $selectedMeals = [];
         if($item){
            foreach($item->meals as $meal){
                $selectedMeals[] = $meal->id; 
            }
         }
        return view($this->pathViewController.'form',[
            'meals'=>$meals,
            'selectedMeals'=>$selectedMeals,
            'item'=>$item,
        ]);
    }

    public function save(AllergenRequest $request){
        $id = $request->id;
        $params = $request->all();
        $mealIds = $request->input('meals',[]); // ds mon duoc chon, con k chọn là mảng rỗng

        if($id){
            // update
            $allergen = AllergenModel::findOrFail($id);
            $allergen->update($params);
            //cap nhat mapping
            $allergen->meals()->sync($mealIds);
            return redirect()->route('allergens.index',['id'=>$allergen->id])->with('success',"Cập nhật Dị ứng '{$allergen->name}' thành công");
        }
        else{
            // create
            $allergen = AllergenModel::create($params);
            if(!empty($mealIds)){
                $allergen->meals()->sync($mealIds);
            }
            return redirect()->route('allergens.index')->with('success', "Thêm mới Dị ứng '{$allergen->name}' thành công");
        }
        
        
    }
    
    public function destroy($id){
        $allergen = AllergenModel::findOrFail($id);
        $name = $allergen->name;// lấy tên trước khi xóa
        $allergen->delete();
        
        // return $item;
        return redirect()->route('allergens.index')->with('success', "Đã xóa Dị ứng '{$name}' thành công");
        
    }


    //================Meal-Allergens CRUD================
     public function mapMeals(Request $request, $id){
        
        $allergen = AllergenModel::findOrFail($id);
        // Gán món ăn mới
        $mealIds = $request->input('meals', []);
        $allergen->meals()->sync($mealIds);
        
        return redirect()->route('allergens.index')->with('success', "Cập nhật món ăn Dị ứng  cho '{$allergen->name}' thành công!"); 
    }

    
}
