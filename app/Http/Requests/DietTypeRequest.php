<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DietTypeRequest extends FormRequest
{
    /**
     * Xác định quyền truy cập
     */
    public function authorize(): bool
    {
        return true; // Cho phép mọi người dùng đã xác thực
    }

    /**
     * Quy tắc validate
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('diet_type', 'name')->ignore($this->route('id')),
                'regex:/^[a-zA-ZÀ-ỹ\s]+$/u', // Chỉ chữ cái và khoảng trắng (không số, không ký tự đặc biệt),
                'min:2', // Tối thiểu 2 ký tự
                
            ],
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh (tiếng Việt)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên loại chế độ ăn là bắt buộc.',
            'name.string'   => 'Tên loại chế độ ăn phải là chuỗi ký tự.',
            'name.max'      => 'Tên loại chế độ ăn không được vượt quá 255 ký tự.',
            'name.unique'   => 'Tên loại chế độ ăn này đã tồn tại.',
            'name.regex'    => 'Tên loại chế độ ăn chỉ được chứa chữ cái và khoảng trắng.',
            'name.min'      => 'Tên loại chế độ ăn phải có ít nhất 2 ký tự.',

        ];
    }

    /**
     * Tên hiển thị của thuộc tính
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên loại chế độ ăn',
        ];
    }
}
