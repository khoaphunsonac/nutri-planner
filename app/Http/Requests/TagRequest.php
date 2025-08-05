<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
                'unique:tags,name,' . $id . ',id', //k check trung với id chính nó
            ],
            
        ];
    }

    /**
     * Get custom validation messages in Vietnamese
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên Tag không để trống',
            'name.string' => 'Tên Tag phải là chuỗi ký tự.',
            'name.min' => 'Tên Tag tối thiểu 2 ký tự.',
            'name.max' => 'Tên Tag không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên Tag này đã tồn tại, vui lòng chọn tên khác.',
        ];
    }

    /**
     * Get custom attribute names in Vietnamese
     */
    
}
