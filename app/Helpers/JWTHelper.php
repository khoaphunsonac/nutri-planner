<?php

namespace App\Helpers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTHelper
{
    /**
     * Tạo token từ user
     */
    public static function createToken($user)
    {
        try {
            return JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return null;
        }
    }

    /**
     * Lấy user từ token
     */
    public static function getUserFromToken($token = null)
    {
        try {
            if ($token) {
                return JWTAuth::setToken($token)->authenticate();
            }
            return JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return null;
        }
    }

    /**
     * Làm mới token
     */
    public static function refreshToken($token = null)
    {
        try {
            if ($token) {
                return JWTAuth::setToken($token)->refresh();
            }
            return JWTAuth::refresh();
        } catch (JWTException $e) {
            return null;
        }
    }

    /**
     * Vô hiệu hóa token
     */
    public static function invalidateToken($token = null)
    {
        try {
            if ($token) {
                return JWTAuth::setToken($token)->invalidate();
            }
            return JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return false;
        }
    }

    /**
     * Kiểm tra token có hợp lệ không
     */
    public static function validateToken($token)
    {
        try {
            JWTAuth::setToken($token)->authenticate();
            return true;
        } catch (JWTException $e) {
            return false;
        }
    }

    /**
     * Lấy thông tin từ token (không cần authenticate)
     */
    public static function getTokenPayload($token)
    {
        try {
            return JWTAuth::setToken($token)->getPayload();
        } catch (JWTException $e) {
            return null;
        }
    }

    /**
     * Lấy thời gian hết hạn của token
     */
    public static function getTokenExpiration($token)
    {
        $payload = self::getTokenPayload($token);
        if ($payload) {
            return $payload->get('exp');
        }
        return null;
    }

    /**
     * Kiểm tra token có sắp hết hạn không (trong vòng 5 phút)
     */
    public static function isTokenExpiringSoon($token, $minutes = 5)
    {
        $exp = self::getTokenExpiration($token);
        if ($exp) {
            $expiringTime = $exp - ($minutes * 60);
            return time() >= $expiringTime;
        }
        return false;
    }
}
