<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    //  public function prepareForValidation()
    //  {
    //     $this->merge([
    //         'patient_id'=>$this->query('patient_id')
    //     ]);
    //  }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'notes'          => 'nullable|string',
            'diagnosis'      => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'follow_up_date' => 'nullable|date|after:today',
        ];
    }
}
