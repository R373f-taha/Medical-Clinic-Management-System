<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
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
            'user_id' => [
                'nullable',
                'exists:users,id',
                Rule::unique('doctors', 'user_id')->ignore($this->doctor),
            ],
            'specialization'   => 'nullable|string|max:255',
            'qualifications'   => 'nullable|string|max:255',
            'available_hours'  => 'nullable|integer|min:0',
            'experience_years' => 'nullable|integer|min:0',
            'Current_rate'     => 'nullable|numeric|min:0|max:5',
        ];
    }
}
