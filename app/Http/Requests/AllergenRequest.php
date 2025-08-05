<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AllergenRequest extends FormRequest
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
        $id = $this->input('id');
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'unique:allergens,name,'. $id . ',id',
            ],
            
        ];
    }

    /**
     * Get custom validation messages in Vietnamese
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên dị ứng không để trống.',
            'name.string' => 'Tên dị ứng phải là chuỗi ký tự.',
            'name.min' => 'Tên dị ứng tối thiểu 2 ký tự.',
            'name.max' => 'Tên dị ứng không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên dị ứng này đã tồn tại, vui lòng chọn tên khác.',

        
        ];
    }

    /**
     * Get custom attribute names in Vietnamese
     */
    
}
