<?php

namespace App\Services\Admin;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;

class InvoiceService
{
    public function getPatients()
    {
        return Patient::with('user')->get();
    }

    public function getAvailableAppointments(?int $ignoreInvoiceId = null)
    {
        return Appointment::with('patient.user')
            ->whereDoesntHave('invoice', function ($q) use ($ignoreInvoiceId) {
                if ($ignoreInvoiceId) {
                    $q->where('id', '!=', $ignoreInvoiceId);
                }
            })
            ->get();
    }

    public function store(array $data)
    {
        return Invoice::create($data);
    }

    public function update(Invoice $invoice, array $data)
    {
        return $invoice->update($data);
    }
}

