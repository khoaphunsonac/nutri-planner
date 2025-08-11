<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra session auth
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Vui lòng đăng nhập để truy cập khu vực admin.');
        }

        // Kiểm tra remember me session
        if (session('admin_remember_me') && session('admin_remember_until')) {
            $rememberUntil = session('admin_remember_until');
            if (now()->gt($rememberUntil)) {
                // Remember me đã hết hạn
                session()->forget(['admin_remember_me', 'admin_remember_until']);
                Auth::logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
            }
        }

        $user = Auth::user();

        // Kiểm tra role admin
        if ($user->role !== 'admin') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Bạn không có quyền truy cập trang admin.');
        }

        // Kiểm tra trạng thái tài khoản
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('admin.login')
                ->with('error', 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.');
        }

        // Kiểm tra và refresh JWT token nếu cần
        if (session('admin_jwt_token')) {
            try {
                $jwtUser = JWTAuth::setToken(session('admin_jwt_token'))->authenticate();
                if (!$jwtUser || $jwtUser->id !== $user->id) {
                    $newToken = JWTAuth::fromUser($user);
                    session(['admin_jwt_token' => $newToken]);
                }
            } catch (JWTException $e) {
                $newToken = JWTAuth::fromUser($user);
                session(['admin_jwt_token' => $newToken]);
            }
        } else {
            // Tạo JWT token mới nếu chưa có
            try {
                $token = JWTAuth::fromUser($user);
                session(['admin_jwt_token' => $token]);
            } catch (JWTException $e) {
                Auth::logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Không thể tạo token. Vui lòng đăng nhập lại.');
            }
        }

        return $next($request);
    }
}
