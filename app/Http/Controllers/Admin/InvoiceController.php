<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
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

    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();

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

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

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
