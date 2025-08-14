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

        // ===== BỔ SUNG =====
        $totalUsers = $user; // Tổng số user hiện tại
        $today = now()->startOfDay(); # now biến thành múi giờ, còn startOfDay là biến now() đó thành 00:00:00 hiện tại
        $newUsersToday = AccountModel::where('role', 'user')
        ->where('created_at', '>=', $today)->count(); # trả về số user hôm hay (CÓ THỂ WHERE NHIỀU LẦN)
        $oldUsers = $totalUsers - $newUsersToday;
        // ====================

        $meals = MealModel::all();
        $feedbacks = FeedbackModel::all();
        $contacts = ContactModel::all();

        # lấy data để vẽ biểu đồ (method quan hệ nhiều)
        $DietTypeCount = DietTypeModel::withCount('meals')->get();

        return view('admin.dashboard', [
            # đếm
            'user' => $user, # đếm mỗi user
            'totalUsers' => $totalUsers, // tổng user
            'newUsersToday' => $newUsersToday, // user mới hôm nay
            'oldUsers' => $oldUsers, // user cũ

            'mealsCount' => $meals->count(),
            'feedbacks' => $feedbacks->count(),
            'contacts' => $contacts->count(),

            # DietTypeCount
            'DietTypeCount' => $DietTypeCount
        ]);
    }
}
