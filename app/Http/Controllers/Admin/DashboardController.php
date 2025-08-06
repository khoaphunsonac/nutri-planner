<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountModel;
use App\Models\MealModel;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller

{
    use AuthorizesRequests, ValidatesRequests;


    public function index() {
    $accounts = AccountModel::all();
   // $meals = MealModel::all();
    # ngày tạo
    $lastDay = AccountModel::orderBy('created_at', 'desc')->first(); // user mới nhất
    $onlyDay = $lastDay ? $lastDay->created_at->format('d-m-Y') : null; // chỉ lấy ngày với format

    return view('admin.dashboard', [
        # đếm
        'accountsCount' => $accounts->count(),
        // 'mealsCount' => $meals->count(),

        # ngày tạo
        'lastDay' => $onlyDay,

        # information
        'allAccounts' => $accounts
    ]);
}
}
