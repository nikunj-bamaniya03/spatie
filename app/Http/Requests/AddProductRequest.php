<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id'         => 'sometimes|required|exists:categories,id',
            'product_name'        => 'required|max:255',
            'product_description' => 'nullable|max:500',
            'product_price'       => 'required|numeric|min:0',
            'product_image'       => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ];
    }
}
