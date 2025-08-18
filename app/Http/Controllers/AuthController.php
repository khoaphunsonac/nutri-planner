<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\AccountModel;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('site.auth.login');
    }

    /**
     * Đăng nhập web và tạo JWT token
     */
   public function webLogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        "username" => "required|string|min:4|max:40",
        'password' => [
            'required',
            'string',
            'min:6',
            'max:20',
            // 'regex:/^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\d).+$/'
                ],
            ], 
        [
        # username
        "username.required" => "Vui lòng điền tên đăng nhập",
        "username.min" => "Tên đăng nhập ít nhất :min ký tự",
        "username.max" => "Tên đăng nhập tối đa :max ký tự",

        # password
        'password.required' => 'Vui lòng nhập mật khẩu',
        'password.min' => 'Mật khẩu phải có ít nhất :min ký tự',
        'password.max' => 'Mật khẩu không được vượt quá :max ký tự',
        // 'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa và 1 chữ số',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput($request->only('username'));
    }

    try {
        $user = AccountModel::where('username', $request->username)->first();
        if(!$user){
            return back()->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng.'])
                         ->withInput($request->only('username'));
        }

        // Refresh user để chắc chắn lấy dữ liệu mới nhất
        $user->refresh();

        if($user->status !== 'active'){
            return back()->withErrors(['username' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.'])
                         ->withInput($request->only('username'));
        }

        if(!Hash::check($request->password, $user->password)){
            return back()->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng.'])
                         ->withInput($request->only('username'));
        }

        // Login và tạo JWT
        Auth::login($user);
        session()->forget('user_jwt_token');
        $token = JWTAuth::fromUser($user);
        session(['user_jwt_token' => $token]);

        if($user->role === 'admin') return redirect('/');

        return redirect('/')->with('success', 'Đăng nhập thành công!');

    } catch (JWTException $e) {
        return back()->withErrors(['username' => 'Không thể tạo token. Vui lòng thử lại.'])
                     ->withInput($request->only('username'));
    } catch (\Exception $e){
        return back()->withErrors(['username' => 'Có lỗi xảy ra. Vui lòng thử lại.'])
                     ->withInput($request->only('username'));
    }
}

    /**
     * Đăng nhập và tạo JWT token (API)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Tìm user theo username
            $user = AccountModel::where('username', $request->username)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.'
                ], 401);
            }

            // Kiểm tra trạng thái tài khoản
            if ($user->status !== 'active') {
                return response()->json([
                    'status' => false,
                    'message' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.'
                ], 403);
            }

            // Kiểm tra mật khẩu
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.'
                ], 401);
            }

            // Tạo JWT token
            $token = JWTAuth::fromUser($user);

            // Lấy thông tin user (loại bỏ password)
            $userData = $user->only(['id', 'username', 'email', 'role', 'status']);

            return response()->json([
                'status' => true,
                'message' => 'Đăng nhập thành công.',
                'data' => [
                    'user' => $userData,
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60 // Thời gian hết hạn tính bằng giây
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể tạo token. Vui lòng thử lại.'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Đăng xuất và vô hiệu hóa token
     */
    public function logout(Request $request)
    {
        try {
            // Vô hiệu hóa token hiện tại
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => true,
                'message' => 'Đăng xuất thành công.'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể đăng xuất. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Làm mới token
     */
    public function refresh(Request $request)
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'status' => true,
                'message' => 'Token đã được làm mới.',
                'data' => [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể làm mới token. Vui lòng đăng nhập lại.'
            ], 401);
        }
    }

    /**
     * Lấy thông tin user hiện tại
     */
    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token không hợp lệ.'
                ], 401);
            }

            $userData = $user->only(['id', 'username', 'email', 'role', 'status']);

            return response()->json([
                'status' => true,
                'message' => 'Lấy thông tin thành công.',
                'data' => $userData
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token không hợp lệ.'
            ], 401);
        }
    }

    /**
     * Kiểm tra token có hợp lệ không
     */
    public function checkToken(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token không hợp lệ.'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Token hợp lệ.',
                'data' => [
                    'user_id' => $user->id,
                    'role' => $user->role
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token không hợp lệ.'
            ], 401);
        }
    }
}
