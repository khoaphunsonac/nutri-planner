<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\AccountModel;

class AdminAuthController extends Controller
{
    /**
     * Hiển thị form đăng nhập admin
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Xử lý đăng nhập admin
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('username'));
        }

        try {
            $user = AccountModel::where('username', $request->username)->first();

            if (!$user) {
                return back()
                    ->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng.'])
                    ->withInput($request->only('username'));
            }

            if ($user->status !== 'active') {
                return back()
                    ->withErrors(['username' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.'])
                    ->withInput($request->only('username'));
            }

            if (!Hash::check($request->password, $user->password)) {
                return back()
                    ->withErrors(['username' => 'Tên đăng nhập hoặc mật khẩu không đúng.'])
                    ->withInput($request->only('username'));
            }

            if ($user->role !== 'admin') {
                return back()
                    ->withErrors(['username' => 'Bạn không có quyền truy cập trang admin.'])
                    ->withInput($request->only('username'));
            }

            // Đăng nhập session với remember me
            $remember = $request->boolean('remember');
            Auth::login($user, $remember);

            // Tạo JWT token và lưu vào session
            $token = JWTAuth::fromUser($user);
            session(['admin_jwt_token' => $token]);

            // Lưu thông tin remember me vào session nếu được chọn
            if ($remember) {
                session(['admin_remember_me' => true]);
                session(['admin_remember_until' => now()->addDays(30)]);
            }

            return redirect()->route('dashboard')
                ->with('success', 'Đăng nhập thành công!');
        } catch (JWTException $e) {
            return back()
                ->withErrors(['username' => 'Không thể tạo token. Vui lòng thử lại.'])
                ->withInput($request->only('username'));
        } catch (\Exception $e) {
            return back()
                ->withErrors(['username' => 'Có lỗi xảy ra. Vui lòng thử lại.'])
                ->withInput($request->only('username'));
        }
    }

    /**
     * Đăng xuất admin
     */
    public function logout(Request $request)
    {
        try {
            // Vô hiệu hóa JWT token
            if (session('admin_jwt_token')) {
                JWTAuth::setToken(session('admin_jwt_token'))->invalidate();
            }

            // Xóa session
            session()->forget('admin_jwt_token');
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('success', 'Đã đăng xuất thành công.');
        } catch (\Exception $e) {
            Auth::logout();
            session()->forget('admin_jwt_token');

            return redirect()->route('admin.login')
                ->with('success', 'Đã đăng xuất thành công.');
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:accounts,email',
        ], [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Gửi email đặt lại mật khẩu
        try {
            $user = AccountModel::where('email', $request->email)->first();
            $token = JWTAuth::fromUser($user);
            Mail::to($user->email)->send(new ResetPasswordMail($token));

            return back()->with('success', 'Đã gửi liên kết đặt lại mật khẩu.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Có lỗi xảy ra. Vui lòng thử lại.']);
        }
    }

    public function showResetForm($token)
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'token.required' => 'Token là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Đặt lại mật khẩu
        try {
            $user = JWTAuth::setToken($request->token)->authenticate();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('admin.login')
                ->with('success', 'Đặt lại mật khẩu thành công.');
        } catch (\Exception $e) {
            return back()->withErrors(['token' => 'Có lỗi xảy ra. Vui lòng thử lại.']);
        }
    }
}
