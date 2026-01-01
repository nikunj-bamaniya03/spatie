<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        // Decrypt role ID from route
        $roleId = decrypt($this->route('id'));


        return [
            'name' => ['required','string','min:3',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'permission' => 'nullable|array',
            'permission.*' => 'string|exists:permissions,name',
        ];
    }
}