<?php
// filepath: app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\AccountModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('site.register.form');
    }
    public function register(RegisterRequest $request)
    {
            // dd($request->all());

        // Create user
        $user = AccountModel::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        # với lần đầu đk thì đăng ký xong thì cho vô ngay
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công');
    }
}
