<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
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
        // $accounts = AccountModel::withCount('feedback')->get(); # gộp in ra hết, theo kiểu đếm số lượng quan hệ 
        $accounts = AccountModel::withCount('feedback')->where('role', 'user')->paginate(7); // chỉ lấy 7 bản ghi mỗi trang
        $Admin = AccountModel::where('role', 'admin')->first(); # hiển thị mỗi admin
        $countUser = $accounts->count();
        # hiển thị tài khoản bị khoá
        $lockedUsers = $accounts->where("status", "inactive")->count();
        return view($this->viewPath.'user', [
            "accounts" => $accounts,
            "countUser" => $countUser,
            "Admin" => $Admin,
            # hiển thị tk bị lock
            "lockedUsers" => $lockedUsers
        ]);
    }
    public function form(Request $request){
        $id = $request->id;
        $item = null;
        $btn = '';
        if($id){
            $item = AccountModel::where("id", $id)->first();
            $btn = $item ? 'lưu thay đổi' : '';
        }
        return view($this->viewPath.'detail', [
            "id" => $id,
            "item" => $item,
            "btn" => $btn
        ]);
    }
    public function edit(Request $request){ # chỉnh sửa cho admin
        $id = $request->id;
        $adminAccount = AccountModel::where('role', 'admin')->first();
        $btnUpdate = $adminAccount ? 'Cập nhật' : '';
        return view($this->viewPath.'formAdmin', [
            "id" => $id,
            "adminAccount" => $adminAccount,
            "btnUpdate" => $btnUpdate
        ]);
    }
    public function update(AdminUserRequest $request){
    //$id = $request->id;
    $admin = AccountModel::where('role', 'admin')->first();

        if ($admin) {
            $admin->username = $request->username;
            $admin->email = $request->email;

            // nếu nhập mật khẩu mới thì mới mã hoá
            if ($request->password) {
                $admin->password = bcrypt($request->password);
            }

            $admin->status = $request->status ?? $admin->status;
            $admin->save();
        }

        return redirect(route('users.index'))->with('success', 'Cập nhật tài khoản thành công');
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
    public function save(Request $request, $id = null){
        $account = $id ? AccountModel::find($id) : new AccountModel();

        $account->username = $request->username;
        $account->email = $request->email;
        if ($request->password) {
            $account->password = bcrypt($request->password);
        }
        $account->status = $request->status ?? 'inactive';
        $account->save();

        return redirect()->route('users.index')->with('success', 'Đã lưu tài khoản');
    }   

    # mở khoá tk
    public function status(Request $request){
        $id = $request->id;
        $accountStatus = '';
        if($id){
            $accountStatus = AccountModel::where('id', $id)->first();
            if($accountStatus){
                $accountStatus->status = $accountStatus->status === 'active' ? 'inactive' : 'active';
                $accountStatus->save();
            }
        }
        # redirect về trang trước
        return redirect()->back()->with('success', 'Đã cập nhật trạng thái tài khoản');
    }
}
