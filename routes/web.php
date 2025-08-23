<?php

use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\NutriController;
use App\Http\Controllers\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\DietTypeController;
use App\Http\Controllers\Admin\MealController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AllergenController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MealTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\FeedbackController as SiteFeedbackController;
use App\Http\Controllers\RegisterController;

// FORM LOGIN (Hiển thị giao diện)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// XỬ LÝ LOGIN
Route::post('/login', [AuthController::class, 'webLogin'])->name('login.submit');

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Group Admin (Protected with JWT)
Route::prefix('admin')->middleware('admin')->group(function () {
    // Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    // INGREDIENT MODULE
    $controller = IngredientController::class;
    Route::prefix('ingredients')->as('ingredients.')->group(function () use ($controller): void {
        Route::get('/', [$controller, 'index'])->name('index');              // Danh sách
        Route::get('/show/{id}', [$controller, 'show'])->name('show');        // Xem chi tiết
        Route::get('/add', [$controller, 'create'])->name('add');             // Trang thêm mới
        Route::get('/show/{id}', [$controller, 'show'])->name('show');        // Xem chi tiết
        Route::get('/form/{id}', [$controller, 'edit'])->name('form');        // Form sửa
        Route::post('/save', [$controller, 'save'])->name('save');            // Lưu thêm hoặc sửa
        Route::post('/save/{id}', [$controller, 'destroy'])->name('delete'); // Xoá
    });

    // DIET TYPE MODULE
    Route::prefix('diet-types')->name('diettypes.')->group(function () {
        Route::get('/', [DietTypeController::class, 'index'])->name('index');
        Route::get('/create', [DietTypeController::class, 'create'])->name('create');
        Route::post('/', [DietTypeController::class, 'store'])->name('store');
        Route::get('/{id}', [DietTypeController::class, 'show'])->name('show'); // Xem chi tiết
        Route::get('/{id}/edit', [DietTypeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DietTypeController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [DietTypeController::class, 'destroy'])->name('destroy'); // dùng GET thay vì DELETE
    });

    # USER MODULE
    $controller = UserController::class;
    Route::prefix('users')->as('users.')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('index');
        Route::get('/form/{id?}', [$controller, 'form'])->name('form');
        Route::get('/detail/{id?}', [$controller, 'detail'])->name('detail');
        Route::get('/edit/{id?}', [$controller, 'edit'])->name('edit'); # sửa tk admin
        Route::post('/edit/{id?}', [$controller, 'update'])->name('update'); # bấm lưu
        Route::get('/delete/{id?}', [$controller, 'delete'])->name('delete');
        Route::post('/save/{id?}', [$controller, 'save'])->name('save');
        # mở & khoá tk
        Route::patch('/status/{id?}', [$controller, 'status'])->name('status');
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

    // ALLERGEN MODULE
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
    Route::prefix('diet-types')->name('diettypes.')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('index');
        Route::get('/create', [$controller, 'create'])->name('create');
        Route::post('/', [$controller, 'store'])->name('store');
        Route::get('/{id}', [$controller, 'show'])->name('show'); // Xem chi tiết
        Route::get('/{id}/edit', [$controller, 'edit'])->name('edit');
        Route::post('/{id}', [$controller, 'update'])->name('update');
        Route::get('/{id}/delete', [$controller, 'destroy'])->name('destroy'); // dùng GET thay vì DELETE
    });

    // CONTACT MODULE
    $controller = ContactController::class;
    Route::prefix('contacts')->group(function () use ($controller) {
        Route::get('/', [$controller, 'index'])->name('contact.index');
        Route::get('/show/{id}', [$controller, 'show'])->name('contact.show');
        Route::get('/delete/{id}/delete', [$controller, 'delete'])->name('contact.delete');
    });

    //FEEDBACK MODULE
    $controller = FeedbackController::class;
    Route::prefix('feedbacks')->as('feedbacks.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');              // Danh sách
        Route::get('/show/{id}', [FeedbackController::class, 'show'])->name('show');        // Xem chi tiết
        Route::post('/delete/{id}', [FeedbackController::class, 'destroy'])->name('destroy'); // Xoá
    });

    // MealType MODULE
    Route::prefix('meal_types')->group(function () {
        Route::get('/',                 [MealTypeController::class, 'index'])->name('admin.meal_types.index');
        Route::get('/create',           [MealTypeController::class, 'create'])->name('admin.meal_types.create');
        Route::post('/store/{id?}',           [MealTypeController::class, 'store'])->name('admin.meal_types.store');
        Route::get('/{id}',             [MealTypeController::class, 'show'])->whereNumber('id')->name('admin.meal_types.show');
        Route::get('/{id}/edit',        [MealTypeController::class, 'edit'])->whereNumber('id')->name('admin.meal_types.edit');
        Route::post('/{id}/update',     [MealTypeController::class, 'update'])->whereNumber('id')->name('admin.meal_types.update');
        Route::get('/{id}/delete',      [MealTypeController::class, 'delete'])->whereNumber('id')->name('admin.meal_types.delete');
    });
});

# register
Route::get('/register', [RegisterController::class, 'showRegister'])->name('showRegister');
# XỬ LÝ REGISTER
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [RegisterController::class, 'logout'])->name('register.logout');


// Meal site
$mealController = MealsController::class;
Route::prefix('meals')->as('meal.')->group(function () use ($mealController) {
    Route::get('/', [$mealController, 'index'])->name('index');
    Route::get('/show/{id}', [$mealController, 'show'])->name('show');


    Route::post('/favorite/{id}', [$mealController, 'favorite'])->middleware('user')->name('favorite');
    Route::get('/favorites', [$mealController, 'showsavemeals'])->middleware('user')->name('showsavemeals');

});

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

//Nutri Calc
Route::get('/nutri-calc', [NutriController::class, 'index'])->name('nutri-calc');

// TDEE Calculator
Route::view('/tdee', 'site.tdee')->name('tdee');

//Contact
Route::get('/contacts', [ContactsController::class, 'index'])->name('contacts.index');
Route::post('/contacts', [ContactsController::class, 'store'])->name('contacts.store');
//Feedback
Route::get('/feedback', [SiteFeedbackController::class, 'create'])->name('feedbacks.create')->middleware('user');
Route::post('/feedback', [SiteFeedbackController::class, 'store'])->name('feedbacks.store')->middleware('user');

//Forget Password
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
