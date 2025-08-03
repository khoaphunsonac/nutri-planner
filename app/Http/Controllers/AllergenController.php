<?php

namespace App\Http\Controllers;

use App\Models\Allergen;
use App\Models\Meal;
use App\Models\MealAllergen;
use App\Models\Tag;
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
        $meals = Meal::with('allergens')->latest()->take(5)->get();
        $mealAllergens = MealAllergen::with(['meals','allergens'])->get();
        $allergen = Allergen::all();
        
        $params = $request->all();
        $search = $params['search'] ?? '';
        $query = Allergen::select('id','name','deleted_at');
        $item = null;
       
        if($search){
             $query = $query->where('name','like',"%$search%")->orwhere('id',$id);
        };
        
        $totalAllergenWithTrashed = Allergen::withTrashed()->get();
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

        $totalMeals = count($meals);
        $totalMappings = count($mealAllergens);
        $usageRate =  $totalAllergens > 0 ? round(($activeAllergens/$totalAllergens) *100) . '%' : '0%';
        // $item = $query->orderBy('id','desc')->get();
        $item = $query->orderBy('id','desc')->paginate(10);
        
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
            'totalMappings'=>$totalMappings,
            'usageRate' =>$usageRate,
            'search'=>$search,
            'item'=>$item,
        ]);
    }

    public function show(Allergen $allergen){
        
        return view($this->pathViewController.'show',[
            
            'item'=>$allergen,
        ]);
    }

    public function create(){
        
        return view($this->pathViewController.'form',[
            
            'item'=>null,
        ]);
    }

    public function store(Request $request){
        
        $params = $request->all();
        $allergen = Allergen::create($params);
        // return redirect()->route('allergens.index')->with('success','Allergen đã được thêm');
        return redirect()->route('allergens.edit', $allergen->id)->with('success', 'Allergen đã được thêm');
    }

    public function edit(Allergen $allergen){
        
        // $item = Tag::findOrFail($id);
        return view($this->pathViewController.'form',[
            
            'item'=>$allergen,
        ]);
        
    }

    public function update(Request $request, Allergen $allergen){
        $params = $request->all();
        $allergen->update($params);
        
        
        // return $item;
        return redirect()->route('allergens.edit',['allergen' => $allergen->id])->with('success', 'Cập nhật thành công');
        
    }
    
    public function destroy(Allergen $allergen){
        
        $allergen->delete();
        
        // return $item;
        return redirect()->route('allergens.index')->with('success', 'Đã xóa Allergen thành công');
        
    }


    //================Meal-Allergens CRUD================
     public function indexMap(){
        
        $mappings = MealAllergen::with(['meals','allergens'])->orderByDesc('id')->take(10)->get();
        $meals = Meal::all();
        $allergens = Allergen::all();
        // return $allergen;
        return view($this->pathViewController.'indexMap',[
            'mappings'=>$mappings,
            'meals'=>$meals,
            'allergens'=>$allergens,
        ]);
        
    }

    public function createMap(Request $request){
        
         $meals = Meal::all();
        $allergens = Allergen::all();
        
        // return $allergen;
        return view($this->pathViewController.'formMap',[
            'meals'=>$meals,
            'allergens'=>$allergens,
        ]);
        
    }

    public function storeMap(Request $request){
        
         $params = $request->only(['meal_id','allergen_id']);
         MealAllergen::create($params);
        
        // return $allergen;
        return redirect()->route('allergens.index')->with('success', 'Tạo Mapping thành công');
        
    }

    public function destroyMap($id){
        
         $mapping = MealAllergen::findOrFail($id);
         $mapping->delete();
        
        // return $allergen;
        return redirect()->route('indexMap')->with('success', 'Xóa Mapping thành công');
        
    }
}
