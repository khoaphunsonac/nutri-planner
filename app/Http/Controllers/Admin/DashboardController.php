<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountModel;
use App\Models\MealModel;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\ContactModel;
use App\Models\DietTypeModel;
use App\Models\FeedbackModel;

class DashboardController extends Controller

{
    use AuthorizesRequests, ValidatesRequests;


    public function dashboard() {
    $accounts = AccountModel::all();
    $user = $accounts->where('role', 'user')->count();

    $meals = MealModel::all();
    $feedbacks = FeedbackModel::all();
    $contacts = ContactModel::all();
    # ngày tạo
    $lastDay = AccountModel::orderBy('created_at', 'desc')->first(); // user mới nhất
    $onlyDay = $lastDay ? $lastDay->created_at->format('d-m-Y') : null; // chỉ lấy ngày với format
    # lấy data để vẽ biểu đồ (method quan hệ nhiều)
    $DietTypeCount = DietTypeModel::withCount('meals')->get();
    return view('admin.dashboard', [
        # đếm
        'user' => $user, # đếm mỗi user
        'mealsCount' => $meals->count(),
        'feedbacks' => $feedbacks->count(),
        'contacts' => $contacts->count(),
        # ngày tạo
        'lastDay' => $onlyDay,

        # information
        'allAccounts' => $accounts,

        # DietTypeCount
        'DietTypeCount' => $DietTypeCount
    ]);
}
}
