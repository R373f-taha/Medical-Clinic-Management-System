<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'specialization'    => 'required|string|max:255',
            'qualifications'    => 'required|string|max:255',
            'available_hours'   => 'required|integer|min:0',
            'experience_years'  => 'nullable|integer|min:0',
            'services'         => 'nullable|string',
           
        ];
    }
}
