<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class StoreRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation()
    {
        $appointment=Appointment::where('doctor_id',$this->doctor_id)
        ->where('patient_id',$this->patient_id)->
        where('status','completed')->first();


        $this->merge([
            'has_completed_appointment'=>(bool)$appointment]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
             'patient_id'  => ['required,
             exists:patients,id',
             function ($attribute, $value, $fail) {
                if($this->has('has_completed_appoinment')&&!$this->has_completed_appointment)
                    return $fail('you should take an appointment before the rating...');
             }
            ],
            'doctor_id' => 'required|exists:doctors,id',
            'rating'    => 'required|numeric|min:1|max:5',
            'notes'     => 'nullable|string',
        ];
    }
}
