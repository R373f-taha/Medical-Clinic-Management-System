<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;

class EmployeeInvoiceController extends Controller
{
    // Show Invoices
    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment'])->latest()->paginate(10);
        return view('Employee.invoices.index', compact('invoices'));
    }

    //Add Invoices
    public function create()
    {
        $patients = Patient::all();
        $appointments = Appointment::whereDoesntHave('invoice')->get();

        return view('Employee.invoices.create', compact('patients', 'appointments'));
    }

    // Store Invoices
    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create($request->validated());

        return redirect()->route('employee.invoices.index')
                         ->with('success', 'Invoice created successfully.');
    }

    // Show Invoices
public function show(Invoice $invoice)
{
    $invoice->load('patient.user', 'appointment');
    
    return view('Employee.invoices.show', compact('invoice'));
}

    // Edit Invoices
    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $appointments = Appointment::all();

        return view('Employee.invoices.edit', compact('invoice', 'patients', 'appointments'));
    }

    // Update Invoices
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->validated());

        return redirect()->route('employee.invoices.index')
                         ->with('success', 'Invoice updated successfully.');
    }

    // Delete Invoices
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('employee.invoices.index')
                         ->with('success', 'Invoice deleted successfully.');
    }
}
