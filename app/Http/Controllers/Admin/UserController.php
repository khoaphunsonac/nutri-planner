<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserRequest;
use App\Http\Requests\LockedUserRequest;
use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // mới thêm này
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
    
    public function index(Request $request){ # ko bắt buộc phải có tham số trên route mới chạy đc
        # chỉ lấy 7 user mỗi trang
        $keyword = $request->get('keyword');    

        $query = AccountModel::query(); # truy vấn
        if($keyword){
            $query->where("username", "like", "%{$keyword}%");
        }   
        $accounts = $query->withCount('feedback')->where('role', 'user')->orderBy('created_at', 'desc')->paginate(7); 

        # hiển thị mỗi admin
        $Admin = AccountModel::where('role', 'admin')->first(); 

        # hiển thị tài khoản bị khoá
        $lockedUsers = AccountModel::where("status", "inactive")->count();
        return view($this->viewPath.'user', [
            "accounts" => $accounts,
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
            "btn" => $btn,
        ]);
    }
    public function detail(Request $request){
        $id = $request->id;

        $users = AccountModel::find($id);
        // dd($meal);   
        return view($this->viewPath.'detailMeal', [
            'id' => $id,
            'users' => $users,
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
    // Tìm tài khoản admin
    $admin = AccountModel::where('role', 'admin')->first();

    // Nếu không tìm thấy
    if (!$admin) {
        return redirect()->back()->with('error', 'Không tìm thấy tài khoản quản trị');
    }

    // Biến này để kiểm tra có thay đổi gì không
    $daThayDoi = false;

    // So sánh và gán username
    $usernameMoi = $request->username;
    if ($admin->username !== $usernameMoi) {
        $admin->username = $usernameMoi;
        $daThayDoi = true;
    }

    // So sánh và gán email
    $emailMoi = $request->email;
    if ($admin->email !== $emailMoi) {
        $admin->email = $emailMoi;
        $daThayDoi = true;
    }

    // Nếu người dùng có nhập mật khẩu mới
    if ($request->filled('password')) {
        $matKhauMoi = $request->password;

        // So sánh mật khẩu mới với mật khẩu cũ (đã mã hoá)
        if (!Hash::check($matKhauMoi, $admin->password)) {
            $admin->password = bcrypt($matKhauMoi);
            $daThayDoi = true;
            }
        }

        // Nếu có bất kỳ thay đổi nào thì mới lưu
        if ($daThayDoi) {
            $admin->save();
            return redirect()->route('users.index')->with('success', 'Đã cập nhật tài khoản quản trị');
        } else {
            return redirect()->back()->with('info', 'Bạn chưa thay đổi thông tin nào');
        }
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
    // public function save(Request $request, $id = null){
    //     # validate chung luôn
    //     $request->validate([
    //         "note" => "nullable|min:4|max:255"
    //     ],[
    //         "note.nullable" => "Hãy ghi lý do khoá tài khoản này", # có thể có ghi chú hoặc không
    //         "note.min" => "Nhập ít nhất :min ký tự",
    //         "note.max" => "Nhập tối đa :max ký tự",
    //     ]);

    //     $account = $id ? AccountModel::find($id) : new AccountModel();

    //     $account->username = $request->username;
    //     $account->email = $request->email;
    //     if ($request->password) {
    //         $account->password = bcrypt($request->password);
    //     }
    //     $account->status = $request->status ?? 'inactive';
    //     $account->note = $request->note; # lý do khoá
    //     $account->save();

    //     return redirect()->route('users.index')->with('success', 'Đã lưu tài khoản');
    // }   
    public function save(Request $request, $id = null)
{
    // Validate lý do khoá nếu có
    $request->validate([
        "note" => "nullable|min:4|max:255"
    ],[
        "note.nullable" => "Hãy ghi lý do khoá tài khoản này",
        "note.min" => "Nhập ít nhất :min ký tự",
        "note.max" => "Nhập tối đa :max ký tự",
    ]);

    // Lấy account nếu $id có, nếu không thì tạo mới
    $account = $id ? AccountModel::find($id) : new AccountModel();

    // Cập nhật thông tin cơ bản (username/email)
    $account->username = $request->username;
    $account->email = $request->email;

    // Chỉ cập nhật mật khẩu nếu người dùng nhập mới
    if ($request->filled('password')) {
        $account->password = bcrypt($request->password);
    }

    // Cập nhật trạng thái và note
    $account->status = $request->status ?? 'inactive';
    $account->note = $request->note;

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
