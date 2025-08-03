<?php

use App\Http\Controllers\AllergenController;
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
    Route::resource('allergens', AllergenController::class);
    // Route::get('allergens/mapping', [AllergenController::class,'indexMap'])->name('indexMap');
    // Route::get('allergens/mapping/create', [AllergenController::class,'createMap'])->name('createMap');
    // Route::post('allergens/mapping/store', [AllergenController::class,'storeMap'])->name('storeMap');
    // Route::delete('allergens/mapping/delete/{id}', [AllergenController::class,'destroyMap'])->name('destroyMap');

    Route::resource('tags', TagController::class);
    // Route::resource('users', UserController::class);
    // Route::resource('feedbacks', FeedbackController::class);
    // Route::resource('contacts', ContactController::class);
});

// Nếu ai làm xong route thì có thể mở route ra, tạm thời bỏ middlleware để test


