<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IngredientController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

// FORM LOGIN (Hiển thị giao diện)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// XỬ LÝ LOGIN
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Admin
Route::prefix('admin')->middleware('admin')->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // INGREDIENT MODULE
    $controller = IngredientController::class;
    Route::prefix('ingredients')->as('ingredients.')->group(function () use ($controller): void {
        Route::get('/', [$controller, 'index'])->name('index');              // Danh sách
        Route::get('/show/{id}', [$controller, 'show'])->name('show');        // Xem chi tiết
        Route::get('/add', [$controller, 'create'])->name('add');             // Trang thêm mới
        Route::get('/show/{id}', [$controller, 'show'])->name('show');        // Xem chi tiết
        Route::get('/form/{id}', [$controller, 'edit'])->name('form');        // Form sửa
        Route::post('/save', [$controller, 'save'])->name('save');            // Lưu thêm hoặc sửa
        Route::post('/delete/{id}', [$controller, 'destroy'])->name('delete'); // Xoá
    });


    // Các controller khác có thể cấu trúc y hệt như vậy:
    // Route::prefix('meals')->as('meals.')->group(function () {
    //     Route::get('/', [...])->name('index');
    //     ...
    // });
});

Route::middleware('user')->group(function () {
    // Route dành riêng cho người dùng thường
});