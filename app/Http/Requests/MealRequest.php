<?php
// filepath: c:\laragon\www\nutri-planner\app\Http\Requests\MealRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class MealRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả users có thể sử dụng request này
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $mealId = $this->route('id') ?? $this->input('id');
        
        return [
            // Basic meal information
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('meals', 'name')->ignore($mealId),
            ],
            'description' => 'nullable|string|max:1000',
            'preparation' => 'nullable|string|max:5000',
            
            // Foreign keys
            'diet_type_id' => 'required|integer|exists:diet_type,id',
            'meal_type_id' => 'required|integer|exists:meal_type,id',
            
            // Image upload
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,gif,webp',
                'max:2048', // 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ],
            
            // Tags relationship
            'tags' => 'nullable|array|max:10',
            'tags.*' => 'integer|exists:tags,id',
            
            // Allergens relationship  
            'allergens' => 'nullable|array|max:20',
            'allergens.*' => 'integer|exists:allergens,id',
            
            // Recipe ingredients
            'ingredients' => 'nullable|array|min:1|max:50',
            'ingredients.*.ingredient_id' => 'required|integer|exists:ingredients,id',
            'ingredients.*.quantity' => [
                'required',
                'numeric',
                'min:0.1',
                'max:10000',
                'regex:/^\d+(\.\d{1,2})?$/' // Cho phép tối đa 2 chữ số thập phân
            ],
            
            // Preparation steps
            'preparation_steps' => 'nullable|array|max:20',
            'preparation_steps.*' => 'string|max:1000|min:5',
            
            // Hidden fields
            'id' => 'nullable|integer|exists:meals,id',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'tên món ăn',
            'description' => 'mô tả',
            'preparation' => 'cách chế biến',
            'diet_type_id' => 'loại chế độ ăn',
            'meal_type_id' => 'loại món ăn',
            'image' => 'hình ảnh',
            'tags' => 'thẻ',
            'tags.*' => 'thẻ',
            'allergens' => 'chất gây dị ứng',
            'allergens.*' => 'chất gây dị ứng',
            'ingredients' => 'nguyên liệu',
            'ingredients.*.ingredient_id' => 'nguyên liệu',
            'ingredients.*.quantity' => 'số lượng nguyên liệu',
            'preparation_steps' => 'các bước chế biến',
            'preparation_steps.*' => 'bước chế biến',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            // Name validation messages
            'name.required' => 'Tên món ăn không được để trống.',
            'name.string' => 'Tên món ăn phải là chuỗi ký tự.',
            'name.max' => 'Tên món ăn không được vượt quá 255 ký tự.',
            'name.min' => 'Tên món ăn phải có ít nhất 3 ký tự.',
            'name.unique' => 'Tên món ăn này đã tồn tại, vui lòng chọn tên khác.',
            
            // Description validation messages
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            
            // Preparation validation messages
            'preparation.string' => 'Cách chế biến phải là chuỗi ký tự.',
            'preparation.max' => 'Cách chế biến không được vượt quá 5000 ký tự.',
            
            // Foreign key validation messages
            'diet_type_id.required' => 'Vui lòng chọn loại chế độ ăn.',
            'diet_type_id.integer' => 'Loại chế độ ăn không hợp lệ.',
            'diet_type_id.exists' => 'Loại chế độ ăn đã chọn không tồn tại.',
            
            'meal_type_id.required' => 'Vui lòng chọn loại món ăn.',
            'meal_type_id.integer' => 'Loại món ăn không hợp lệ.',
            'meal_type_id.exists' => 'Loại món ăn đã chọn không tồn tại.',
            
            // Image validation messages
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, jpg, png, gif, webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'image.dimensions' => 'Kích thước hình ảnh phải từ 100x100px đến 2000x2000px.',
            
            // Tags validation messages
            'tags.array' => 'Thẻ phải là một mảng.',
            'tags.max' => 'Không được chọn quá 10 thẻ.',
            'tags.*.integer' => 'Thẻ không hợp lệ.',
            'tags.*.exists' => 'Thẻ đã chọn không tồn tại.',
            
            // Allergens validation messages
            'allergens.array' => 'Chất gây dị ứng phải là một mảng.',
            'allergens.max' => 'Không được chọn quá 20 chất gây dị ứng.',
            'allergens.*.integer' => 'Chất gây dị ứng không hợp lệ.',
            'allergens.*.exists' => 'Chất gây dị ứng đã chọn không tồn tại.',
            
            // Ingredients validation messages
            'ingredients.array' => 'Nguyên liệu phải là một mảng.',
            'ingredients.min' => 'Phải có ít nhất 1 nguyên liệu.',
            'ingredients.max' => 'Không được có quá 50 nguyên liệu.',
            'ingredients.*.ingredient_id.required' => 'Vui lòng chọn nguyên liệu.',
            'ingredients.*.ingredient_id.integer' => 'Nguyên liệu không hợp lệ.',
            'ingredients.*.ingredient_id.exists' => 'Nguyên liệu đã chọn không tồn tại.',
            'ingredients.*.quantity.required' => 'Vui lòng nhập số lượng nguyên liệu.',
            'ingredients.*.quantity.numeric' => 'Số lượng phải là số.',
            'ingredients.*.quantity.min' => 'Số lượng phải lớn hơn 0.1.',
            'ingredients.*.quantity.max' => 'Số lượng không được vượt quá 10000.',
            'ingredients.*.quantity.regex' => 'Số lượng chỉ được có tối đa 2 chữ số thập phân.',
            
            // Preparation steps validation messages
            'preparation_steps.array' => 'Các bước chế biến phải là một mảng.',
            'preparation_steps.max' => 'Không được có quá 20 bước chế biến.',
            'preparation_steps.*.string' => 'Bước chế biến phải là chuỗi ký tự.',
            'preparation_steps.*.max' => 'Mỗi bước chế biến không được vượt quá 1000 ký tự.',
            'preparation_steps.*.min' => 'Mỗi bước chế biến phải có ít nhất 5 ký tự.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();
        
        // Log validation errors for debugging
        Log::info('MealRequest validation failed:', $errors->toArray());
        
        parent::failedValidation($validator);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Custom validation: Check for duplicate ingredients
            if ($this->has('ingredients')) {
                $ingredients = $this->input('ingredients', []);
                $ingredientIds = array_column($ingredients, 'ingredient_id');
                $duplicates = array_diff_assoc($ingredientIds, array_unique($ingredientIds));
                
                if (!empty($duplicates)) {
                    $validator->errors()->add('ingredients', 'Không được chọn trùng nguyên liệu.');
                }
            }
            
            // Custom validation: Check if meal name contains inappropriate words
            if ($this->has('name')) {
                $inappropriateWords = ['test', 'dummy', 'fake'];
                $name = strtolower($this->input('name'));
                
                foreach ($inappropriateWords as $word) {
                    if (strpos($name, $word) !== false) {
                        $validator->errors()->add('name', 'Tên món ăn không được chứa từ không phù hợp.');
                        break;
                    }
                }
            }
            
            // Custom validation: Check total ingredients quantity
            if ($this->has('ingredients')) {
                $ingredients = $this->input('ingredients', []);
                $totalQuantity = array_sum(array_column($ingredients, 'quantity'));
                
                if ($totalQuantity > 5000) {
                    $validator->errors()->add('ingredients', 'Tổng số lượng nguyên liệu không được vượt quá 5000g.');
                }
            }
        });
    }

    /**
     * Get validated data with custom processing
     * Thay thế method validated() để tương thích với Laravel
     */
    public function getValidatedData()
    {
        $validated = parent::validated();

        // Debug: Log validated data
        Log::debug('MealRequest validated data:', $validated);

        // Process preparation steps
        if (isset($validated['preparation_steps'])) {
            $steps = array_filter($validated['preparation_steps'], function($step) {
                return trim($step) !== '';
            });
            $validated['preparation'] = implode("\n", $steps);
            unset($validated['preparation_steps']);
        }

        // Ensure arrays are properly formatted
        $validated['tags'] = $validated['tags'] ?? [];
        $validated['allergens'] = $validated['allergens'] ?? [];
        $validated['ingredients'] = $validated['ingredients'] ?? [];

        return $validated;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Convert empty strings to null for nullable fields
        $data = $this->all();
        
        foreach (['description', 'preparation'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }
        
        // Ensure arrays are arrays, not strings
        foreach (['tags', 'allergens', 'ingredients', 'preparation_steps'] as $field) {
            if (isset($data[$field]) && !is_array($data[$field])) {
                $data[$field] = [];
            }
        }
        
        $this->replace($data);
    }
}