<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'patient_id'      => 'required|exists:patients,id',
            'appointment_id'  => 'required|exists:appointments,id|unique:invoices,appointment_id',
            'tax'             => 'required|integer|min:0',
            'discount'        => 'required|integer|min:0',
            'status'          => 'required|in:paid,unpaid',
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|integer|min:0',
            'payment_method'  => 'required|in:cash,card,online,bank_transfer',
        ];
    }
}
