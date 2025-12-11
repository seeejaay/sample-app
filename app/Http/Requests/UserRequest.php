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
        $userId = $this->route('user');
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
            'schedule_ids' => 'nullable|array|max:2',
            'schedule_ids.*' => 'integer|exists:schedules,id',
        ];
    }

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