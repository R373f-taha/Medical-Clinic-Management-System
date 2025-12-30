<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
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
            'patient_id'     => 'nullable|exists:patients,id',
            'appointment_id' => [
                'nullable',
                'exists:appointments,id',
                Rule::unique('invoices', 'appointment_id')->ignore($this->route('invoices')),
            ],
            'tax'            => 'nullable|integer|min:0',
            'discount'       => 'nullable|integer|min:0',
            'status'         => 'nullable|in:paid,unpaid',
            'invoice_date'   => 'nullable|date',
            'total_amount'   => 'nullable|integer|min:0',
            'payment_method' => 'nullable|in:cash,card,online,bank_transfer',
        ];
    }
}
