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
        $tagMeal  = TagModel::with('meals')->paginate(10);
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
        $item = $query->orderBy('id','desc')->paginate(10);
        
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
        ]);
    }

    public function show($id,Request $request){
        $tag = TagModel::with('meals')->findOrFail($id);
        return view($this->pathViewController.'show',[
            
            'item'=>$tag,
        ]);
    }

    public function form($id =null){
        $item = $id ? TagModel::findOrFail($id) : null;
        return view($this->pathViewController.'form',[
            'item'=>$item,
        ]);
    }



    public function save(TagRequest $request){
        $params = $request->all();
        if(!empty($params['id'])){
            $tag = TagModel::findOrFail($params['id']);
            $tag->update($params);
            return redirect()->route('tags.index',['id'=>$tag->id])->with('success',"Cập nhật Thẻ `{$tag->name}` thành công");
        }else{
            $params = $request->only(['name']);
            $tag =TagModel::create($params);
            return redirect()->route('tags.index')->with('success',"Thêm Thẻ '{$tag->name}' thành công");
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
