<?php

namespace App\Services\Admin;

use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Doctor;

class InvoiceService
{
    public function getAll()
    {
        return Invoice::with(['patient', 'doctor'])
            ->latest()
            ->get();
    }

    public function getPatients()
    {
        return Patient::all();
    }

    public function getDoctors()
    {
        return Doctor::all();
    }

    public function store(array $data)
    {
        return Invoice::create($data);
    }

    public function update(Invoice $invoice, array $data)
    {
        $invoice->update($data);
        return $invoice;
    }

    public function delete(Invoice $invoice)
    {
        return $invoice->delete();
    }
}