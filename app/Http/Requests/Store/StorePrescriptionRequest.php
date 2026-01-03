<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
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
            'medical_record_id' => 'required|exists:medical_records,id',
            'medicine_name'     => 'required|string|max:255',
            'dosage'            => 'required|integer|min:1',
            'frequency'         => 'required|integer|min:1',
            'refills'           => 'required|string|max:50',
            'instructions'      => 'required|string',
            'duration'          => 'required|integer|min:1',
        ];
    }
}
