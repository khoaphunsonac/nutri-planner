<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeedbackRequest extends FormRequest
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

            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:500|regex:/^[\p{L}0-9\s]+$/u',

        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh (tiếng Việt)
     */
    public function messages(): array
    {
        return [
            'rating.required' => 'Vui lòng chọn đánh giá.',
            'rating.integer'  => 'Đánh giá phải là số nguyên.',
            'rating.min'      => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max'      => 'Đánh giá tối đa là 5 sao.',

            'comment.required' => 'Vui lòng nhập nội dung phản hồi.',
            'comment.min'      => 'Phản hồi phải có ít nhất 5 ký tự.',
            'comment.max'      => 'Phản hồi tối đa 500 ký tự.',
            'comment.regex'    => 'Phản hồi chỉ được chứa chữ cái, số và khoảng trắng.',

        ];
    }
}
