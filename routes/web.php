<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AllergenController;
use App\Http\Controllers\Admin\DietTypeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

// Group Admin
Route::prefix('admin')->group(function () {
    // Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

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

    Route::prefix('feedbacks')->as('feedbacks.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');              // Danh sách
        Route::get('/show/{id}', [FeedbackController::class, 'show'])->name('show');        // Xem chi tiết
        Route::post('/delete/{id}', [FeedbackController::class, 'destroy'])->name('destroy'); // Xoá
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

    // TAG MODULE
    $controller = TagController::class;
    Route::prefix('tags')->as('tags.')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('index');                   // Danh sách
        Route::get('/show/{id}', [$controller, 'show'])->name('show');          // Xem chi tiết
        Route::get('/add', [$controller, 'form'])->name('add');                // Trang thêm
        Route::get('/form/{id}', [$controller, 'form'])->name('form');          // Form sửa
        Route::post('/save', [$controller, 'save'])->name('save');               // Lưu (thêm hoặc sửa)
        Route::post('/delete/{id}', [$controller, 'destroy'])->name('delete');  // Xóa

        //===========Mapping Tag-Meal==========

        Route::post('/{id}/mapmeals', [$controller, 'mapMeals'])->name('mapMeals')->where('id', '[0-9]+');
    });

    $controller = AllergenController::class;
    Route::prefix('allergens')->as('allergens.')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('index');                // Danh sách
        Route::get('/show/{id}', [$controller, 'show'])->name('show');        // Xem chi tiết
        Route::get('/add', [$controller, 'form'])->name('add');             // Trang thêm mới
        Route::get('/form/{id}', [$controller, 'form'])->name('form');        // Form sửa
        Route::post('/save', [$controller, 'save'])->name('save');            // Lưu thêm hoặc sửa
        Route::post('/delete/{id}', [$controller, 'destroy'])->name('delete'); // Xoá
        // Mapping meal-allergen
        Route::post('/{id}/mapping', [$controller, 'mapMeals'])->name('mapMeals');
    });

    // DIET TYPE MODULE
    $controller = DietTypeController::class;

    // CONTACT MODULE
    $controller = ContactController::class;
    Route::prefix('contact')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('contact.index');
        Route::get('/show/{id}', [$controller, 'show'])->name('contact.show');
        Route::get('/delete/{id}/delete', [$controller, 'delete'])->name('contact.delete');
    });

    //FEEDBACK MODULE
    $controller = FeedbackController::class;

    // Các controller khác có thể cấu trúc y hệt như vậy:
    // Route::prefix('meals')->as('meals.')->group(function () {
    //     Route::get('/', [...])->name('index');
    //     ...
    // });
});

// tạm thời không dùng middlewarem thời bỏ middlleware để test
