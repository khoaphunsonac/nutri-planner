<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchFillterRequest extends FormRequest
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
            'search' => 'nullable|string|max:255',
            'calories_min' => 'nullable|numeric|min:0',
            'calories_max' => 'nullable|numeric|min:0',
                
        
            
            
        ];
    }

    /**
     * Get custom validation messages in Vietnamese
     */
    public function messages(): array
    {
        return [
            'search.string' => 'Ô tìm kiếm phải là ký tự.',
            'search.max' => 'Tìm kiếm tối đa 255 ký tự.',

            'calories_min.numeric' => 'Calories phải nhập số.',
            'calories_min.min' => 'Calories không được phép âm.',

            'calories_max.numeric' => 'Calories phải nhập số.',
            'calories_max.min' => 'Calories không được phép âm.',
        ];
    }

    /**
     * Get custom attribute names in Vietnamese
     */
    
}
