<?php

use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IngredientController;
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

    //=================Route Tags======================
    // Route::resource('tags', TagController::class);
    $tagController = TagController::class;
    Route::prefix('tags')->as('tags.')->group(function () use($tagController) {
        Route::get('/', [$tagController, 'index'])->name('index');                   // Danh sách
         Route::get('/show/{id}', [$tagController, 'show'])->name('show')->where('id', '[0-9]+');;          // Xem chi tiết
        Route::get('/add', [$tagController, 'form'])->name('add');                // Trang thêm
        Route::get('/form/{id}', [$tagController, 'form'])->name('form');          // Form sửa
        Route::post('/save', [$tagController, 'save'])->name('save');               // Lưu (thêm hoặc sửa)
        Route::post('/delete/{id}', [$tagController, 'destroy'])->name('delete');  // Xóa

        //===========Mapping Tag-Meal==========
        Route::get('/{id}/mapmeals', [$tagController, 'showMapping'])->name('showMapping')->where('id', '[0-9]+');; 
        Route::post('/{id}/mapmeals', [$tagController, 'mapMeals'])->name('mapMeals')->where('id', '[0-9]+');;




       
    });


    // Các controller khác có thể cấu trúc y hệt như vậy:
    // Route::prefix('meals')->as('meals.')->group(function () {
    //     Route::get('/', [...])->name('index');
    //     ...
    // });
});

// tạm thời không dùng middlewarem thời bỏ middlleware để test


