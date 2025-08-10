<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra session auth
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để truy cập.');
        }

        $user = Auth::user();

        // Kiểm tra role user
        if ($user->role !== 'user') {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Chỉ người dùng thường mới được truy cập phần này.');
        }

        // Kiểm tra trạng thái tài khoản
        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt.');
        }

        // Kiểm tra và refresh JWT token nếu cần
        if (session('user_jwt_token')) {
            try {
                $jwtUser = JWTAuth::setToken(session('user_jwt_token'))->authenticate();
                if (!$jwtUser || $jwtUser->id !== $user->id) {
                    $newToken = JWTAuth::fromUser($user);
                    session(['user_jwt_token' => $newToken]);
                }
            } catch (JWTException $e) {
                $newToken = JWTAuth::fromUser($user);
                session(['user_jwt_token' => $newToken]);
            }
        } else {
            // Tạo JWT token mới nếu chưa có
            try {
                $token = JWTAuth::fromUser($user);
                session(['user_jwt_token' => $token]);
            } catch (JWTException $e) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Không thể tạo token. Vui lòng đăng nhập lại.');
            }
        }

        return $next($request);
    }
}
