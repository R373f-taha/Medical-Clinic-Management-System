<?php

//namespace App\Http\Requests;
namespace App\Http\Requests\Store;  // ⬅️ غير هذا
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePatientRequest extends FormRequest
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
    //  public function prepareForValidation():void
    //  {
    //    $this->merge([
    //         'user_id'=> Auth::id()
    //         ]
    //     );

    //  }
    public function rules(): array
    {
        return [
            // بيانات User
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',

            // بيانات Patient
            'blood_type' => 'required',//|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'height' => 'nullable|numeric|min:50|max:250',
            'weight' => 'nullable|numeric|min:10|max:300',
            'gender' => 'required|in:male,female',
            'allergies' => 'nullable|string|max:500'
        ];
    }
}
