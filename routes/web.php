<?php

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
    return view('welcome');
});

// routes/web.php
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('meals', Admin\MealController::class);
    Route::resource('ingredients', Admin\IngredientController::class);
    Route::resource('recipes', Admin\RecipeController::class);
    Route::resource('allergens', Admin\AllergenController::class);
    Route::resource('users', Admin\UserController::class);
    Route::resource('feedbacks', Admin\FeedbackController::class);
    Route::resource('contacts', Admin\ContactController::class);
});

