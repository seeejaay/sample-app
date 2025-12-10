<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
class PositionRequest extends FormRequest
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
        $positionId = $this->route('id');
        $isUpdate = $this->isMethod('put') || $this->isMethod('patch');
        $required = $isUpdate ? 'sometimes' : 'required';
        return [
            //
            'name' => [
                $required,
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s]+$/',
                Rule::unique('positions', 'name')->ignore($positionId),
            ],
            'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s.,"\'\-]+$/',
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'name.unique' => 'The position name has already been taken.',
    //         'name.required' => 'The position name is required.',
    //         'name.string' => 'The position name must be a string.',
    //         'name.regex' => 'The position name can only contain letters and spaces.',
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
