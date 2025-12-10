<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'firstname' => "{$required}|string|max:255|regex:/^[a-zA-Z\s]+$/|",
            'middlename' => ($isUpdate ? 'sometimes|' : '') . "nullable|string|max:255|regex:/^[a-zA-Z\s]+$/",
            'lastname' => "{$required}|string|max:255|regex:/^[a-zA-Z\s]+$/",
            'email' => [
                $isUpdate ? 'sometimes' : 'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => "{$required}|string|min:8|confirmed|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]+$/",
            'role_id' => "{$required}|exists:roles,id",
            'position_id' => "{$required}|exists:positions,id",
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'firstname.regex' => 'First name can only contain letters and spaces.',
    //         'middlename.regex' => 'Middle name can only contain letters and spaces.',
    //         'lastname.regex' => 'Last name can only contain letters and spaces.',
    //         'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
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