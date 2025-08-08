<?php
// filepath: c:\laragon\www\nutri-planner\app\Http\Requests\MealRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->input('id');
        
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[\p{L}\s]+$/u',
                Rule::unique('meals', 'name')->ignore($id),
            ],
            'meal_type_id' => 'required|exists:meal_type,id',
            'diet_type_id' => 'required|exists:diet_type,id',
            'description' => 'nullable|string|max:2000',
            'preparation' => 'nullable|string|max:5000',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            'tags' => 'nullable|array|max:10',
            'tags.*' => 'exists:tags,id',
            'allergens' => 'nullable|array|max:20',
            'allergens.*' => 'exists:allergens,id',
            'ingredients' => 'nullable|array|min:1|max:50',
            'ingredients.*.ingredient_id' => 'required|exists:ingredients,id',
            'ingredients.*.quantity' => 'required|numeric|min:0.1|max:10000',
            'preparation_steps' => 'nullable|array|max:20',
            'preparation_steps.*' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên món ăn không được để trống.',
            'name.min' => 'Tên món ăn phải có ít nhất :min ký tự.',
            'name.max' => 'Tên món ăn không được vượt quá :max ký tự.',
            'name.unique' => 'Tên món ăn này đã tồn tại, vui lòng chọn tên khác.',
            'name.regex' => 'Tên món ăn chỉ được chứa chữ cái và khoảng trắng.',

            'meal_type_id.required' => 'Vui lòng chọn loại bữa ăn.',
            'meal_type_id.exists' => 'Loại bữa ăn được chọn không hợp lệ.',

            'diet_type_id.required' => 'Vui lòng chọn chế độ ăn.',
            'diet_type_id.exists' => 'Chế độ ăn được chọn không hợp lệ.',

            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
            'preparation.max' => 'Cách chế biến không được vượt quá :max ký tự.',

            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
            'image.dimensions' => 'Hình ảnh phải có kích thước từ 100x100px đến 2000x2000px.',

            'tags.array' => 'Tags phải là một mảng.',
            'tags.max' => 'Không được chọn quá :max tags.',
            'tags.*.exists' => 'Tag được chọn không hợp lệ.',

            'allergens.array' => 'Chất gây dị ứng phải là một mảng.',
            'allergens.max' => 'Không được chọn quá :max chất gây dị ứng.',
            'allergens.*.exists' => 'Chất gây dị ứng được chọn không hợp lệ.',

            'ingredients.array' => 'Nguyên liệu phải là một mảng.',
            'ingredients.min' => 'Phải có ít nhất :min nguyên liệu.',
            'ingredients.max' => 'Không được có quá :max nguyên liệu.',
            'ingredients.*.ingredient_id.required' => 'ID nguyên liệu là bắt buộc.',
            'ingredients.*.ingredient_id.exists' => 'Nguyên liệu được chọn không hợp lệ.',
            'ingredients.*.quantity.required' => 'Số lượng nguyên liệu là bắt buộc.',
            'ingredients.*.quantity.numeric' => 'Số lượng nguyên liệu phải là số.',
            'ingredients.*.quantity.min' => 'Số lượng nguyên liệu phải ít nhất :min.',
            'ingredients.*.quantity.max' => 'Số lượng nguyên liệu không được vượt quá :max.',

            'preparation_steps.array' => 'Các bước chế biến phải là một mảng.',
            'preparation_steps.max' => 'Không được có quá :max bước chế biến.',
            'preparation_steps.*.string' => 'Bước chế biến phải là chuỗi ký tự.',
            'preparation_steps.*.max' => 'Mỗi bước chế biến không được vượt quá :max ký tự.',
        ];
    }

    /**
     * Process preparation steps before validation
     */
    protected function prepareForValidation()
    {
        // Process preparation steps
        if ($this->has('preparation_steps')) {
            $steps = array_filter($this->preparation_steps ?? [], function($step) {
                return !empty(trim($step));
            });
            
            // Convert steps array to string for storage
            $this->merge([
                'preparation' => implode("\n", $steps)
            ]);
        }
    }
}