<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép tất cả user dùng request này (nếu có auth có thể giới hạn lại)
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:100',
            'unit'     => 'nullable|string|max:20',
            'protein'  => 'nullable|numeric|min:0',
            'carb'     => 'nullable|numeric|min:0',
            'fat'      => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên nguyên liệu.',
            'name.max' => 'Tên nguyên liệu không quá 100 ký tự.',
            'protein.numeric' => 'Protein phải là số.',
            'carb.numeric' => 'Carb phải là số.',
            'fat.numeric' => 'Fat phải là số.',
        ];
    }
}
