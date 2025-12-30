<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|unique:patients,user_id',
            'blood_type' => 'required|string|max:5',
            'height'     => 'required|numeric',
            'weight'     => 'required|numeric',
            'gender'     => 'required|string|in:male,female',
            'allergies'  => 'required|string',
        ];
    }
}
