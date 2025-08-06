<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\ContactController;
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
    # A.Khoa code
        Route::prefix('contacts')->group(function(){
        Route::get('', [ContactController::class, 'index'])->name('contact.index');
        Route::get('/{id}', [ContactController::class, 'detail'])->name('contact.show');
        Route::get('/{id}/delete', [ContactController::class, 'delete'])->name('contact.delete');
    });
       
});


    // Các controller khác có thể cấu trúc y hệt như vậy:
    // Route::prefix('meals')->as('meals.')->group(function () {
    //     Route::get('/', [...])->name('index');
    //     ...
    // });


// tạm thời không dùng middlewarem thời bỏ middlleware để test


