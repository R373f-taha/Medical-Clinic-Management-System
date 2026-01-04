<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRateRequest extends FormRequest
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
            'patient_id'  => 'nullable|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'rating'    => 'nullable|numeric|min:1|max:5',
            'notes'     => 'nullable|string',
        ];
    }
}
