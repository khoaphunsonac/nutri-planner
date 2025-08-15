<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

    class LayoutController extends Controller
{
    public function index() {
        $currentUser = Auth::user(); // Lấy user đang đăng nhập
        return view('site.layout', [
            'newAccount' => $currentUser
        ]);
    }

}

