<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type'              => 'required|string|in:x-ray,lab,scan,other',
        ];
    }
}
