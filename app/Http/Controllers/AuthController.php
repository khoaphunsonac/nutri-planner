<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        // Debug: Log the attempt
        Log::info('Login attempt', [
            'username' => $credentials['username'],
            'user_exists' => \App\Models\AccountModel::where('username', $credentials['username'])->exists()
        ]);

        if (Auth::attempt($credentials)) {
            // Nếu login thành công
            $request->session()->regenerate();

            Log::info('Login successful', ['user_id' => Auth::id(), 'role' => Auth::user()->role]);

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/');
        }

        Log::warning('Login failed', ['username' => $credentials['username']]);

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Đã đăng xuất.');
    }
}
