<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
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
            'patient_id'   =>['nullable','exists:patients,id'],
            'doctor_id'         => 'nullable|exists:doctors,id',
            'medical_record_id' => [
                'nullable',
                'exists:medical_records,id',
            ],
            'appointment_date'  => 'nullable|date',
            'status'            => 'nullable|in:scheduled,completed,cancelled',
            'notes'             => 'nullable|string',
            'reason'            => 'nullable|string',
        ];
    }
}
