<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_id'     => 'nullable|exists:patients,id',
            'appointment_id' => [
                'nullable',
                'exists:appointments,id',
                Rule::unique('invoices', 'appointment_id')->ignore($this->invoice->id),
            ],
            'tax'            => 'nullable|integer|min:0',
            'discount'       => 'nullable|integer|min:0',
            'status'         => 'nullable|in:paid,unpaid',
            'invoice_date'   => 'nullable|date',
            'payment_method' => 'nullable|in:cash,card,online,bank_transfer',
        ];
    }
}
