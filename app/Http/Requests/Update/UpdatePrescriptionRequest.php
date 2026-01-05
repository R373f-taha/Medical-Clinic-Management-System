<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrescriptionRequest extends FormRequest
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
            //'medical_record_id' => 'nullable|exists:medical_records,id',
            'medicine_name'     => 'nullable|string|max:255',
            'dosage'            => 'nullable|integer|min:1',
            'frequency'         => 'nullable|integer|min:1',
            'refills'           => 'nullable|string|max:50',
            'instructions'      => 'nullable|string',
            'duration'          => 'nullable|integer|min:1',
        ];
    }
}
