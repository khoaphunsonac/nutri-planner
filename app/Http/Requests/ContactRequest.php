<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|min:3|max:100',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Vui lòng nhập họ tên.',
            'name.min'         => 'Họ tên phải có ít nhất 3 ký tự.',
            'email.required'   => 'Vui lòng nhập email.',
            'email.email'      => 'Email không đúng định dạng.',
            'message.required' => 'Vui lòng nhập nội dung.',
            'message.min'      => 'Nội dung phải có ít nhất 5 ký tự.',
        ];
    }
}
