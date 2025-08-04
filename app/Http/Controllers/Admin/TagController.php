<?php

namespace App\Http\Controllers;

use App\Models\Tag;
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
        $tags = Tag::all();
        
        $params = $request->all();
        $search = $params['search'] ?? '';
        $query = Tag::select('id','name','deleted_at');
        $item = null;
       
        if($search){
             $query = $query->where('name','like',"%$search%")->orwhere('id',$id);
        };
        
        $totalTagsWithTrashed = Tag::withTrashed()->get();
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
        ]);
    }

    public function show(Tag $tag){
        
        return view($this->pathViewController.'show',[
            
            'item'=>$tag,
        ]);
    }

    public function create(){
        
        return view($this->pathViewController.'form',[
            
            'item'=>null,
        ]);
    }

    public function store(Request $request){
        
        $params = $request->all();
        Tag::create($params);
        return redirect()->route('tags.index')->with('success','Tag đã được thêm');
        
    }

    public function edit(Tag $tag){
        
        // $item = Tag::findOrFail($id);
        return view($this->pathViewController.'form',[
            
            'item'=>$tag,
        ]);
        
    }

    public function update(Request $request, Tag $tag){
        $params = $request->all();
        $tag->update($params);
        
        
        // return $item;
        return redirect()->route('tags.edit',['tag' => $tag->id])->with('success', 'Cập nhật thành công');
        
    }
    
    public function destroy(Tag $tag){
        
        $tag->delete();
        
        // return $item;
        return redirect()->route('tags.index')->with('success', 'Đã xóa tag thành công');
        
    }
}
