<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        $roleId = $this->route('role');
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
        $required = $isUpdate ? 'sometimes' : 'required';
        
        return [
            'name' => [
                $required,
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s.,"\'\-]+$/',
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'name.unique' => 'The role name has already been taken.',
    //         'name.required' => 'The role name is required.',
    //         'name.string' => 'The role name must be a string.',
    //         'name.regex' => 'The role name can only contain letters and spaces.',
    //         'description.string' => 'The description must be a string.',
    //         'description.regex' => 'The description can only contain letters, numbers, spaces, and punctuation marks like .,"\'-',
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}