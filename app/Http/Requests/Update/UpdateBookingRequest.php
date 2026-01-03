<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id'        => 'nullable|exists:doctors,id',
            'appointment_date' => 'nullable|date',
            'status'           => 'nullable|in:scheduled,completed,cancelled',
            'reason'           => 'nullable|string',
            'notes'            => 'nullable|string',
        ];
    }
}
