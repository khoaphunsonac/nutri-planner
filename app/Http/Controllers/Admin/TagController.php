<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use App\Models\MealModel;
use App\Models\TagModel;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request ;
use Illuminate\Routing\Controller as BaseController;

use function PHPUnit\Framework\isEmpty;

class TagController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public $controllerName = "tag";
    public $pathViewController = "admin.tags.";

    public function index(Request $request){
        $id = $request->id;
        $tags = TagModel::all();
        $tagMeal  = TagModel::with('meals')->paginate(10,['*'],'mappingmeal');
        $itemMeal = TagModel::with('meals')->get();
        $allMeals =  MealModel::select('id','name')->get();
        $params = $request->all();
        $search = $params['search'] ?? '';
        $query = TagModel::withCount('meals')->whereNull('deleted_at');
        $item = null;
        $meals = MealModel::all();
        if($search){
             $query = $query->where('name','like',"%$search%");
        };
        
        $totalTagsWithTrashed = TagModel::withTrashed()->get();
        // tổng số tag
        $totalTags = count($totalTagsWithTrashed);
        //  return $totalTagsWithTrashed;
        // đếm số tag đang hoạt động
        $activeTags = 0;
        //  chưa lọc được tag bị xóa, đặt cứng
        $deletedTags = 0;
        //lập qua all tag để đém trạng thái
        foreach($totalTagsWithTrashed as $tag){
            if($tag['deleted_at'] === null){
                $activeTags++ ;
            }else{
                $deletedTags++ ;
            }
        }
        $usageRate =  $totalTags > 0 ? round(($activeTags/$totalTags) *100) . '%' : '0%';
        // $item = $query->orderBy('id','desc')->get();
        $item = $query->orderBy('id','desc')->paginate(10,['*'],'tags');
        // Tính chỉ số bắt đầu đếm ngược (số lớn nhất trên trang hiện tại)
        $total = $item->total();
        $perPage = $item->perPage();
        $currentPage = $item->currentPage();
        $startIndex = $total - ($currentPage - 1) * $perPage;
        //  return $item;
        return view($this->pathViewController.'index',[
            'tags'=> $tags,
            'totalTagsWithTrashed'=>$totalTagsWithTrashed,
            'totalTags'=>$totalTags,
            'activeTags'=>$activeTags,
            'deletedTags'=>$deletedTags,
            'usageRate' =>$usageRate,
            'search'=>$search,
            'item'=>$item,
            'tagMeal'=>$tagMeal,
            'allMeals'=>$allMeals,
            'meals'=>$meals,
            'itemMeal' =>$itemMeal,
            'startIndex'=>$startIndex,
        ]);
    }

    public function show($id,Request $request){
        $tag = TagModel::with('meals')->findOrFail($id);
        
        return view($this->pathViewController.'show',[
            
            'item'=>$tag,
        ]);
    }

    public function form(Request $request){
         $id=$request->id;
        $item = $id ? TagModel::with('meals')->findOrFail($id) : null;

        // lay ds mon an co phan trang
         $meals = MealModel::orderBy('name','asc')->paginate(20,['*'],'meals_page');
         //neu dang edit lay mang ID mon an da duoc gan
         $selectedMeals = [];
         
         if($item){
            foreach($item->meals as $meal){
                $selectedMeals[] = $meal->id; //lay id cua tung mon an gan
            }
         }
        
        return view($this->pathViewController.'form',[
            'item'=>$item,
            'meals'=>$meals,
            'selectedMeals'=>$selectedMeals,
        ]);
    }



    public function save(TagRequest $request){
        $id = $request->id;
        $params = $request->all(); 
        $mealIds = $request->input('meals',[]); // ds mon duoc chon, con k chọn là mảng rỗng
       
        if($id){
            $tag = TagModel::findOrFail($id);
            $tag->update($params);
            //cap nhat mapping
            $tag->meals()->sync($mealIds);
           
            return redirect()->route('tags.index',['id'=>$tag->id])->with('success',"Cập nhật Dị ứng '{$tag->name}' thành công");
        }else{
            
            $tag =TagModel::create($params);
            if(!empty($mealIds)){
                $tag->meals()->sync($mealIds);
            }
             return $tag;
            return redirect()->route('tags.index')->with('success', "Thêm mới Dị ứng '{$tag->name}' thành công");
        }
    }
    
    public function destroy($id){
        $tag = TagModel::findOrFail($id);
        $name = $tag->name;// lấy tên trước khi xóa
        $tag->delete();
        
        // return $item;
        return redirect()->route('tags.index')->with('success', "Đã xóa Thẻ '{$name}' thành công");
        
    }


     //===========Mapping============
    public function mapMeals(Request $request, $id)
    {
        $tag = TagModel::findOrFail($id);
        $mealIds = $request->input('meals', []);
        $tag->meals()->sync($mealIds);

        return redirect()->route('tags.index')->with('success', "Đã cập nhật liên kết món ăn cho Thẻ '{$tag->name}'");
    }
}
