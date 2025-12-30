<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'user_id'        => 'required|exists:users,id|unique:employees,user_id',
            'name'           => 'required|string|max:255',
            'qualificatins'  => 'required|string|max:255',
            'age'            => 'required|integer|min:18',
            'phone'          => 'required|string|max:20|unique:employees,phone',
            'email'          => 'required|email|unique:employees,email',
            'gender'         => 'required|in:Male,Female',
            'date_of_birth'  => 'nullable|date',
        ];
    }
}
