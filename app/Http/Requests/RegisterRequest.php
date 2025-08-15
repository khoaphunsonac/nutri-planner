<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            // Gmail với .com, .vn hoặc .com.vn, cho phép số và chữ cái trước @
        'regex:/^[a-zA-Z0-9._%+-]+@gmail\.(com|vn|com\.vn)$/',
        Rule::unique('accounts', 'email'),
        ],
        'password' => [
            'required',
            'string',
            'min:6',
            'max:20',
            'regex:/^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\d).+$/'
        ],
         // Xác nhận nhập lại mật khẩu
        'password_confirmation' => 'required'
    ];
}


    public function messages(){
    return [
        # username
        "username.required" => "Vui lòng điền tên đăng nhập",
        "username.min" => "Tên đăng nhập ít nhất :min ký tự",
        "username.max" => "Tên đăng nhập tối đa :max ký tự",

        # email
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không hợp lệ',
        'email.min' => 'Email phải có ít nhất :min ký tự',
        'email.max' => 'Email không được vượt quá :max ký tự',
        'email.regex' => 'Phải đúng gmail và kết thúc bằng .com, .vn hoặc .com.vn',
        'email.unique' => 'Email này đã được sử dụng',

        # password
        'password.required' => 'Vui lòng nhập mật khẩu',
        'password.min' => 'Mật khẩu phải có ít nhất :min ký tự',
        'password.max' => 'Mật khẩu không được vượt quá :max ký tự',
        'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa và 1 chữ số',

        # password_confirmation
        'password_confirmation.required' => 'Vui lòng nhập lại mật khẩu',
    ];
}


}