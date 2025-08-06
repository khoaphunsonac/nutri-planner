<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\MealController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

// Group Admin
Route::prefix('admin')->group(function () {
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

    // MEAL MODULE
    $controller = MealController::class;
    Route::prefix('meals')->as('meals.')->group(function () use ($controller): void {
        Route::get('/', [$controller, 'index'])->name('index');              // Danh sách
        Route::get('/show/{id}', [$controller, 'show'])->name('show');        // Xem chi tiết
        Route::get('/add', [$controller, 'create'])->name('add');             // Trang thêm mới
        Route::get('/form/{id}', [$controller, 'edit'])->name('form');        // Form sửa
        Route::post('/save', [$controller, 'save'])->name('save');            // Lưu thêm hoặc sửa
        Route::post('/delete/{id}', [$controller, 'destroy'])->name('delete'); // Xoá

        // AJAX endpoints
        Route::get('/api/meal-types', [$controller, 'getMealTypes'])->name('api.meal-types');
        Route::get('/api/diet-types', [$controller, 'getDietTypes'])->name('api.diet-types');
    });

    # CONTACT MODULE
        Route::prefix('contact')->group(function(){
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/show/{id}', [ContactController::class, 'show'])->name('contact.show');
        Route::get('/delete/{id}/delete', [ContactController::class, 'delete'])->name('contact.delete');
    });
       
});


// Các controller khác có thể cấu trúc y hệt như vậy:
// Route::prefix('meals')->as('meals.')->group(function () {
//     Route::get('/', [...])->name('index');
//     ...
// });


// tạm thời không dùng middlewarem thời bỏ middlleware để test
