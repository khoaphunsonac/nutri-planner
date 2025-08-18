<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest; // FormRequest để validate
use App\Models\ContactModel; // Model admin đã có sẵn

class ContactsController extends Controller
{
    /**
     * Hiển thị form liên hệ cho người dùng
     */
    public function index()
    {
        return view('site.contact.index'); // Giao diện form liên hệ
    }

    /**
     * Xử lý form liên hệ, validate & lưu DB
     */
    public function store(ContactRequest $request)
    {
        // Lưu dữ liệu vào bảng contacts thông qua model admin
      
        {
            // ✅ Thêm validate
            $request->validate([
                'name'    => ['required', 'regex:/^[\pL\s]+$/u'],
                'email'   => ['required', 'email'],
                'message' => ['required', 'string'],
            ], [
                'name.required' => 'Vui lòng nhập họ tên.',
                'name.regex'    => 'Họ tên chỉ được nhập chữ, không được chứa số, ký tự đặc biệt hoặc @.',
                'email.required' => 'Vui lòng nhập email.',
                'email.email'    => 'Email không hợp lệ.',
                'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
            ]);
        
            // ✅ Giữ code cũ
            ContactModel::create([
                'name'    => $request->name,
                'email'   => $request->email,
                'message' => $request->message,
            ]);
        
            // ✅ Giữ code cũ
            return redirect()
                ->route('contacts.index')
                ->with('success', 'Gửi thành công!');
        }
    }    
    
}