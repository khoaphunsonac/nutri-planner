<?php

namespace App\Http\Controllers\Admin;

use App\Models\AccountModel;
use App\Models\MealModel;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\ContactModel;
use App\Models\FeedbackModel;

class DashboardController extends Controller

{
    use AuthorizesRequests, ValidatesRequests;


    public function dashboard() {
    $accounts = AccountModel::all();
    $meals = MealModel::all();
    $feedbacks = FeedbackModel::all();
    $contacts = ContactModel::all();
    # ngày tạo
    $lastDay = AccountModel::orderBy('created_at', 'desc')->first(); // user mới nhất
    $onlyDay = $lastDay ? $lastDay->created_at->format('d-m-Y') : null; // chỉ lấy ngày với format

    return view('admin.dashboard', [
        # đếm
        'accountsCount' => $accounts->count(),
        'mealsCount' => $meals->count(),
        'feedbacks' => $feedbacks->count(),
        'contacts' => $contacts->count(),
        # ngày tạo
        'lastDay' => $onlyDay,

        # information
        'allAccounts' => $accounts
    ]);
}
}
