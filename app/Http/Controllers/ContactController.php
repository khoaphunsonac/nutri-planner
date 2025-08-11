<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest; // FormRequest để validate
use App\Models\ContactModel; // Model admin đã có sẵn

class ContactController extends Controller
{
    /**
     * Hiển thị form liên hệ cho người dùng
     */
    public function index()
    {
        return view('site.contact'); // Giao diện form liên hệ
    }

    /**
     * Xử lý form liên hệ, validate & lưu DB
     */
    public function store(ContactRequest $request)
    {
        // Lưu dữ liệu vào bảng contacts thông qua model admin
        ContactModel::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        // Redirect về trang liên hệ + thông báo
        return redirect()
            ->route('contact.index')
            ->with('success', 'Gửi thành công!');
    }
}
