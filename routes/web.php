<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// routes/web.php
Route::prefix('administrator')->group(function () {
    // Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Route::resource('meals', MealController::class);
    // Route::resource('ingredients', IngredientController::class
    // Route::resource('recipes', RecipeController::class);
    // Route::resource('allergens', AllergenController::class);

    //=================Route Tags======================
    // Route::resource('tags', TagController::class);
    Route::prefix('tags')->name('tags.')->group(function () {
        Route::get('/', [TagController::class, 'index'])->name('index');
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/', [TagController::class, 'store'])->name('store');
        Route::get('/{tag}', [TagController::class, 'show'])->name('show');
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('edit');
        Route::put('/{tag}', [TagController::class, 'update'])->name('update');
        Route::delete('/{tag}', [TagController::class, 'destroy'])->name('destroy');
    });
    
    // Route::resource('users', UserController::class);
    // Route::resource('feedbacks', FeedbackController::class);
    // Route::resource('contacts', ContactController::class);
});

// Nếu ai làm xong route thì có thể mở route ra, tạm thời bỏ middlleware để test


