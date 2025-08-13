# JWT Authentication cho Admin Panel

## Tổng quan

Hệ thống đã được tích hợp JWT (JSON Web Token) vào các middleware hiện có (`IsAdmin.php` và `IsUser.php`) để bảo mật và quản lý phiên đăng nhập. Chỉ sử dụng cho web routes, không có API endpoints.

## Cách sử dụng

### 1. Truy cập admin login

```
GET /admin/login
```

### 2. Đăng nhập admin

```
POST /admin/login
{
    "username": "admin_username",
    "password": "admin_password"
}
```

### 3. Truy cập user login

```
GET /login
```

### 4. Đăng nhập user

```
POST /login
{
    "username": "user_username",
    "password": "user_password"
}
```

### 5. Truy cập admin dashboard

```
GET /admin/
```

### 6. Đăng xuất

```
POST /admin/logout (admin)
POST /logout (user)
```

## Files đã tạo/cập nhật

### Controllers

-   `AdminAuthController`: Xử lý đăng nhập/đăng xuất admin với JWT
-   `AuthController`: Thêm method `webLogin()` cho user login với JWT

### Middleware (Đã tích hợp JWT)

-   `IsAdmin`: Bảo vệ admin routes với JWT + session
-   `IsUser`: Bảo vệ user routes với JWT + session

### Views

-   `resources/views/admin/auth/login.blade.php`: Form đăng nhập admin
-   `resources/views/admin/layout.blade.php`: Layout admin với nút đăng xuất

### Routes

-   Admin authentication routes trong `routes/web.php`
-   User authentication routes trong `routes/web.php`
-   Đã xóa tất cả API routes không cần thiết

## Tính năng bảo mật

1. **Dual Authentication**: Kết hợp session auth và JWT
2. **Role-based Access**: Phân quyền admin/user
3. **Token Management**: Tự động refresh và vô hiệu hóa
4. **Session Security**: Xóa session khi đăng xuất
5. **Web-only**: Chỉ dùng cho web routes, không có API
6. **Integrated**: JWT tích hợp vào middleware hiện có

## Cấu hình

### JWT Settings (config/jwt.php)

```php
'ttl' => env('JWT_TTL', 60), // 60 phút
'refresh_ttl' => env('JWT_REFRESH_TTL', 20160), // 14 ngày
```

### Session Settings (config/session.php)

```php
'lifetime' => env('SESSION_LIFETIME', 120), // 2 giờ
```

## Dọn dẹp

-   ✅ Đã xóa JWTAdminMiddleware (API)
-   ✅ Đã xóa JWTAuthMiddleware (API)
-   ✅ Đã xóa JWTUserMiddleware (API)
-   ✅ Đã xóa AdminJWTMiddleware (web)
-   ✅ Đã xóa tất cả API routes
-   ✅ Tích hợp JWT vào IsAdmin.php và IsUser.php
-   ✅ Thêm webLogin() method cho AuthController
