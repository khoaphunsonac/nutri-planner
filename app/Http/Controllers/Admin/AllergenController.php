<?php

namespace App\Http\Controllers\Admin;

use App\Models\AllergenModel;
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
        $meals = MealModel::with('allergens')->latest()->take(5)->get();
        $mealAllergens = MealAllergenModel::with(['meal','allergen'])->get();
        $allergen = AllergenModel::all();
        
        $params = $request->all();
        $search = $params['search'] ?? '';
        $query = AllergenModel::select('id','name','deleted_at');
        $mealSearch = $params['mealSearch'] ?? '';
        $allergenSearch = $params['allergenSearch'] ?? '';
        // Truy vấn Mapping có kèm điều kiện lọc
        $mappingQuery = MealAllergenModel::with(['meal', 'allergen'])->orderBy('id', 'desc');

        $query = AllergenModel::select('id','name','deleted_at');
        $item = null;
       
        if($search){
             $query = $query->where('name','like',"%$search%")->orwhere('id',$id);
        };
        if($mealSearch){
             $mappingQuery = $mappingQuery->whereHas('meal', function ($query) use($mealSearch) { $query->where('name', 'like', "%$mealSearch%");});
        };
        if($allergenSearch){
            $mappingQuery = $mappingQuery->whereHas('allergen', function ($query) use($allergenSearch) { $query->where('name', 'like', "%$allergenSearch%");});
        };

        $totalMealsModel = MealModel::count();
        $totalAllergenWithTrashed = AllergenModel::withTrashed()->get();
        // tổng số tag
        $totalAllergens = count($totalAllergenWithTrashed);
        //  return $totalTagsWithTrashed;
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
        // Lấy kết quả phân trang
        $mappingPaginate = $mappingQuery->paginate(10);
        $totalMeals = count($meals);
        // $totalMappings = count($mealAllergens);
        $usageRate =  $totalAllergens > 0 ? round(($activeAllergens/$totalAllergens) *100) . '%' : '0%';
        // $item = $query->orderBy('id','desc')->get();
        $item = $query->orderBy('id','desc')->paginate(10);
        // Clone để đếm số mục sau lọc
        $totalMappings = MealAllergenModel::count();
        //  return $item;
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
            'mappingPaginate'=>$mappingPaginate,
            'mealSearch'=>$mealSearch,
            'allergenSearch'=>$allergenSearch,
        ]);
    }

    public function show($id){
         $allergen = AllergenModel::findOrFail($id);
        return view($this->pathViewController.'show',[
            
            'item'=>$allergen,
        ]);
    }

    public function form($id = null){
         $item = $id ? AllergenModel::findOrFail($id) : null;
        return view($this->pathViewController.'form',[
            
            'item'=>$item,
        ]);
    }

    public function save(Request $request){
        $params = $request->all();
        if(!empty($params['id'])){
            // update
            $allergen = AllergenModel::findOrFail($params['id']);
            $allergen->update($params);
            return redirect()->route('allergens.form',['id'=>$allergen->id])->with('success','Cập nhật Allergen thành công');
        }
        else{
            // create
            $allergen = AllergenModel::create($params);
            return redirect()->route('allergens.form',['id' => $allergen->id])->with('success', 'Thêm mới Allergen thành công');
        }
        
        
    }
    
    public function destroy($id){
        $allergen = AllergenModel::findOrFail($id);
        $allergen->delete();
        
        // return $item;
        return redirect()->route('allergens.index')->with('success', 'Đã xóa Allergen thành công');
        
    }


    //================Meal-Allergens CRUD================
     public function indexMap(){
        
        $mappings = MealAllergenModel::with(['meals','allergens'])->orderByDesc('id')->take(10)->get();
        $meals = MealModel::all();
        $allergens = AllergenModel::all();
        // tổng sô  mục của mapping và  dị ứng theo món
        $totalMappings = MealAllergenModel::with(['meal','allergen']);
        
        // return $allergen;
        return view($this->pathViewController.'indexMap',[
            'mappings'=>$mappings,
            'meals'=>$meals,
            'allergens'=>$allergens,
            'totalMappings'=>$totalMappings,
            
        ]);

        
    }

    public function createMap(Request $request){
        
         $meals = MealModel::all();
        $allergens = AllergenModel::all();
        
        // return $allergen;
        return view($this->pathViewController.'formMap',[
            'meals'=>$meals,
            'allergens'=>$allergens,
        ]);
        
    }

    public function storeMap(Request $request){
        
         $params = $request->only(['meal_id','allergen_id']);
         MealAllergenModel::create($params);
        
        // return $allergen;
        return redirect()->route('allergens.index')->with('success', 'Tạo Mapping thành công');
        
    }

    public function destroyMap($id){
        
         $mapping = MealAllergenModel::findOrFail($id);
         $mapping->delete();
        
        // return $allergen;
        return redirect()->route('allergens.index')->with('success', 'Xóa Mapping thành công');
        
    }
}
