<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public $viewPath = 'admin.users.';
    public $myController = 'users.';

    public function __construct()
    {
        View::share('shareUser', $this->myController);
    }
    # sau mở rộng truyền về dashboard
    public function index(){
        $accounts = AccountModel::withCount('feedback')->get(); # gộp in ra hết, theo kiểu đếm số lượng quan hệ 
        $countUser = $accounts->count();
        return view($this->viewPath.'user', [
            "accounts" => $accounts,
            "countUser" => $countUser,
            # hiển thị 1 user có nhiều feedback
        ]);
    }
    public function form(Request $request){
        $id = $request->id;
        $item = null;
        $btn = '';
        if($id){
            $item = AccountModel::where("id", $id)->first();
            $btn = $item ? 'lưu' : '';
        }
        return view($this->viewPath.'form', [
            "id" => $id,
            "item" => $item,
            "btn" => $btn
        ]);
    }
    public function delete(Request $request){
        $id = $request->id;
        if($id){
            $account = AccountModel::where("id", $id)->first();
            if($account){
                $account->delete();
            }else{
                return redirect(route('users.index', ['id' => $id]));
            }
        }
        return redirect(route('users.index', ['id' => $id]));
    }
}
