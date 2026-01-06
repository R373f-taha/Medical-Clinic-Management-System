<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'user_id' => [
            //     'nullable',
            //     'exists:users,id',
            //     Rule::unique('patient', 'user_id')->ignore($this->patient),
            // ],
            'blood_type' => 'nullable|string|max:5',
            'height'     => 'nullable|numeric',
            'weight'     => 'nullable|numeric',
            'gender'     => 'nullable|string|in:male,female',
            'allergies'  => 'nullable|string',
        ];
    }
}
