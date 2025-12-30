<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'user_id'       => [
                'nullable',
                'exists:users,id',
                Rule::unique('employees', 'user_id')->ignore($this->route('employees')),
            ],
            'name'          => 'nullable|string|max:255',
            'qualificatins' => 'nullable|string|max:255',
            'age'           => 'nullable|integer|min:18',
            'phone'         => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('employees', 'phone')->ignore($this->route('employees')),
            ],
            'email'         => [
                'nullable',
                'email',
                Rule::unique('employees', 'email')->ignore($this->route('employees')),
            ],
            'gender'        => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date',
        ];
    }
}
