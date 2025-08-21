<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IngredientRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ingredients', 'name')->ignore($this->input('id'))
            ],
            'unit' => 'required|string|in:gram,ml,kg,l,piece,tbsp,tsp,cup,slice,pack',
            'protein' => 'required|numeric|min:0|max:100',
            'carb' => 'required|numeric|min:0|max:100',
            'fat' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom validation messages in Vietnamese
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên nguyên liệu là bắt buộc.',
            'name.string' => 'Tên nguyên liệu phải là chuỗi ký tự.',
            'name.max' => 'Tên nguyên liệu không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên nguyên liệu này đã tồn tại, vui lòng chọn tên khác.',

            'unit.required' => 'Đơn vị là bắt buộc.',
            'unit.string' => 'Đơn vị phải là chuỗi ký tự.',
            'unit.in' => 'Đơn vị phải là một trong các giá trị: g, ml, kg, l, cái, muỗng canh, muỗng cà phê, cốc, lát, gói.',

            'protein.required' => 'Hàm lượng protein là bắt buộc.',
            'protein.numeric' => 'Hàm lượng protein phải là số.',
            'protein.min' => 'Hàm lượng protein không được nhỏ hơn 0.',
            'protein.max' => 'Hàm lượng protein không được lớn hơn 100g.',

            'carb.required' => 'Hàm lượng carbohydrate là bắt buộc.',
            'carb.numeric' => 'Hàm lượng carbohydrate phải là số.',
            'carb.min' => 'Hàm lượng carbohydrate không được nhỏ hơn 0.',
            'carb.max' => 'Hàm lượng carbohydrate không được lớn hơn 100g.',

            'fat.required' => 'Hàm lượng chất béo là bắt buộc.',
            'fat.numeric' => 'Hàm lượng chất béo phải là số.',
            'fat.min' => 'Hàm lượng chất béo không được nhỏ hơn 0.',
            'fat.max' => 'Hàm lượng chất béo không được lớn hơn 100g.',
        ];
    }

    /**
     * Get custom attribute names in Vietnamese
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên nguyên liệu',
            'unit' => 'đơn vị',
            'protein' => 'protein',
            'carb' => 'carbohydrate',
            'fat' => 'chất béo',
        ];
    }
}
