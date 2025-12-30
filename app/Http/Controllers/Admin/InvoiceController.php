<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use App\Services\Admin\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $invoices = $this->invoiceService->getAll();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $patients = $this->invoiceService->getPatients();
        $appointments = $this->invoiceService->getAppointments();

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id'      => 'required|exists:patient,id',
            'appointment_id'  => 'required|exists:appointments,id|unique:invoices,appointment_id',
            'tax'             => 'required|integer|min:0',
            'discount'        => 'required|integer|min:0',
            'status'          => 'required|in:paid,unpaid',
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|integer|min:0',
            'payment_method'  => 'required|in:cash,card,online,bank_transfer',
        ]);

        $this->invoiceService->store($data);

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment']);
    }

    public function edit(Invoice $invoice)
    {
        $patients = $this->invoiceService->getPatients();
        $appointments = $this->invoiceService->getAppointments();

    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'patient_id'      => 'required|exists:patient,id',
            'appointment_id'  => 'required|exists:appointments,id|unique:invoices,appointment_id,' . $invoice->id,
            'tax'             => 'required|integer|min:0',
            'discount'        => 'required|integer|min:0',
            'status'          => 'required|in:paid,unpaid',
            'invoice_date'    => 'required|date',
            'total_amount'    => 'required|integer|min:0',
            'payment_method'  => 'required|in:cash,card,online,bank_transfer',
        ]);

        $this->invoiceService->update($invoice, $data);

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'تم تعديل الفاتورة');
    }

    public function destroy(Invoice $invoice)
    {
        $this->invoiceService->delete($invoice);
        return back()->with('success', 'تم حذف الفاتورة');
    }
}
