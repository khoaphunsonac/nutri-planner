<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LayoutController extends Controller
{
    public function index()
    {
        
        $currentUser = Auth::user();# Lấy user đang đăng nhập (nếu có)

        return view('site.layout', [
            'currentUser' => $currentUser
        ]);
    }
}
