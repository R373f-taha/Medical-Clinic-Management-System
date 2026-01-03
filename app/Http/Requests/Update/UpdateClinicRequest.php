<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => ['nullable','email', Rule::unique('clinic')->ignore($this->route('clinic'))],
        ];
    }
}
