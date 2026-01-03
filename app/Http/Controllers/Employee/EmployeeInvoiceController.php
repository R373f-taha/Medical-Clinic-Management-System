<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class EmployeeInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['patient', 'appointment'])->latest()->paginate(10);
        return view('Employee.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = Patient::all();
        
        $appointments = Appointment::whereDoesntHave('invoice')->get();
        
        return view('Employee.invoices.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id|unique:invoices',
            'tax'            => 'required|numeric|min:0',
            'discount'       => 'required|numeric|min:0',
            'status'         => 'required|in:paid,unpaid',
            'invoice_date'   => 'required|date',
            'total_amount'   => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,online,bank_transfer',
        ]);

        Invoice::create($validated);

        return redirect()->route('employee.invoices.index')
                         ->with('success', 'تم إنشاء الفاتورة بنجاح.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment']);
        
        return view('Employee.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = Patient::all();
        $appointments = Appointment::all();
        
        return view('Employee.invoices.edit', compact('invoice', 'patients', 'appointments'));
    }


    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'appointment_id' => 'required|exists:appointments,id|unique:invoices,appointment_id,' . $invoice->id,
            'tax'            => 'required|numeric',
            'discount'       => 'required|numeric',
            'status'         => 'required|in:paid,unpaid',
            'invoice_date'   => 'required|date',
            'total_amount'   => 'required|numeric',
            'payment_method' => 'required|in:cash,card,online,bank_transfer',
        ]);

        $invoice->update($validated);

        return redirect()->route('employee.invoices.index')
                         ->with('success', 'تم تحديث الفاتورة بنجاح.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('employee.invoices.index')
                         ->with('success', 'تم حذف الفاتورة بنجاح.');
    }
}