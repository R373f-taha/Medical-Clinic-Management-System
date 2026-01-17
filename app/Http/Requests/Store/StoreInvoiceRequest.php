<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'patient_id'     => 'required|exists:patients,id',
        'appointment_id' => 'required|exists:appointments,id|unique:invoices,appointment_id',
        'subtotal'       => 'required|numeric|min:0',
        'tax'            => 'required|integer|min:0',
        'discount'       => 'required|integer|min:0',
        'status'         => 'required|in:paid,unpaid',
        'invoice_date'   => 'required|date',
        'payment_method' => 'required|in:cash,card,online,bank_transfer',
    ];
}

}
