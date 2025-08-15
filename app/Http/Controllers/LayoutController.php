<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountModel;

    class LayoutController extends Controller
{
    public function index(){
        $newAccount = AccountModel::orderBy('created_at', 'desc')->first(); # lấy user mới nhất
        return view('site.layout', [
            'newAccount' => $newAccount
        ]);
    }
    
}
