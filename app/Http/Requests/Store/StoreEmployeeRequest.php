<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'       => 'nullable|exists:users,id', 
            'name'          => 'required|string|max:255',
            'qualifications' => 'required|string|max:255',
            'age'           => 'required|integer|min:18',
            'phone'         => 'required|string|max:20|unique:employees,phone',
            'email'         => 'required|email|unique:employees,email',
            'gender'        => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
        ];
    }
}
