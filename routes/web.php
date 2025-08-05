<?php

use App\Http\Controllers\Admin\AllergenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IngredientController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('home');
});

// routes/web.php
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

    //================Route Allergens================
    // Route::resource('allergens', AllergenController::class);
    // Route::get('allergens/mapping', [AllergenController::class,'indexMap'])->name('indexMap');
    // Route::get('allergens/mapping/create', [AllergenController::class,'createMap'])->name('createMap');
    // Route::post('allergens/mapping/store', [AllergenController::class,'storeMap'])->name('storeMap');
    // Route::delete('allergens/mapping/delete/{id}', [AllergenController::class,'destroyMap'])->name('destroyMap');
    $allergenController = AllergenController::class;
        Route::prefix('allergens')->as('allergens.')->group(function () use ($allergenController) {
        Route::get('/', [$allergenController, 'index'])->name('index');                // Danh sách
        Route::get('/show/{id}', [$allergenController, 'show'])->name('show');        // Xem chi tiết
        Route::get('/add', [$allergenController, 'form'])->name('add');             // Trang thêm mới
        Route::get('/form/{id}', [$allergenController, 'form'])->name('form');        // Form sửa
        Route::post('/save', [$allergenController, 'save'])->name('save');            // Lưu thêm hoặc sửa
        Route::post('/delete/{id}', [$allergenController, 'destroy'])->name('delete'); // Xoá

        // Mapping meal-allergen
        Route::post('/{id}/mapping', [$allergenController, 'mapMeals'])->name('mapMeals');
        // Route::get('/mapping/add', [$allergenController, 'createMap'])->name('mapping.add');
        // Route::post('/mapping/save', [$allergenController, 'storeMap'])->name('mapping.save');
        // Route::post('/mapping/delete/{id}', [$allergenController, 'destroyMap'])->name('mapping.delete');
    });


    // Các controller khác có thể cấu trúc y hệt như vậy:
    // Route::prefix('meals')->as('meals.')->group(function () {
    //     Route::get('/', [...])->name('index');
    //     ...
    // });
});

// tạm thời không dùng middlewarem thời bỏ middlleware để test


