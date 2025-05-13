<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PatientRequest extends FormRequest
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
            'name' => [
                'required', 
                'max:50', 
                'regex:/^[a-zA-Z0-9\s\'.]+$/',
            ],
            'id_type' => [
                'nullable',
                'string',
                'max:50',
            ],
            'id_no' => [
                'nullable',
                'string',
            ],
            'gender' => [
                'nullable',
                'in:male,female,other',
            ],
            'dob' => [
                'nullable',
                'date_format:Y-m-d',
            ],
            'address' => [
                'nullable',
                'string',
            ],
            'medium_acquisition' => [
                'nullable',
                'string',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors,
        ], 422));
    }
}
