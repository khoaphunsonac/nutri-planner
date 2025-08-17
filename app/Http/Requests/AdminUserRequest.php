<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all authenticated users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(){
        return [
            "username" => "required|string|min:4|max:40",
            'email' => [
                'required',
                'email',
                'min:10',
                'max:50',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/'
            ],

             'password' => [
                'nullable', # cho phép để trống
                'string',
                'min:6',
                'max:20',
                'regex:/^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ];
    }

    public function messages(){
        return [
            # username
            "username.required" => "Vui lòng điền tên đăng nhập",
            "username.min" => "tên đăng nhập ít nhất :min ký tự",
            "username.max" => "tên đăng nhập tối đa :max ký tự",

            # email
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.min' => 'Email phải có ít nhất :min ký tự',
            'email.max' => 'Email không được vượt quá :max ký tự',
            'email.regex' => 'Email chứa ít nhất 1 chữ cái, 1 số và kết thúc bằng .com',

            # password
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự',
            'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa và 1 chữ số',
        ];
    }

}
