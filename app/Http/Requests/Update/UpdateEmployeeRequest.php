<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'nullable',
                'exists:users,id',
                Rule::unique('employees', 'user_id')->ignore($this->route('employee')),
            ],
            'name'          => 'nullable|string|max:255',
            'qualifications' => 'nullable|string|max:255',
            'age'           => 'nullable|integer|min:18',
            'phone' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('employees', 'phone')->ignore($this->route('employee')),
            ],
            'email' => [
                'nullable',
                'email',
                Rule::unique('employees', 'email')->ignore($this->route('employee')),
            ],
            'gender'        => 'nullable|in:Male,Female',
            'date_of_birth' => 'nullable|date',
        ];
    }
}
