<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StoreInvoiceRequest;
use App\Http\Requests\Update\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Services\Admin\InvoiceService;
use Illuminate\Support\Facades\DB;

class EmployeeInvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

public function index()
{
    $invoices = Invoice::with(['patient.user'])
        ->latest()
        ->paginate(10);

    return view('Employee.invoices.index', compact('invoices'));
}

public function create()
{
    $patients = $this->invoiceService->getPatients();
    $appointments = $this->invoiceService->getAvailableAppointments();

    return view('Employee.invoices.create', compact('patients', 'appointments'));
}

    public function store(StoreInvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->invoiceService->store($request->validated());
            DB::commit();

            return redirect()
                ->route('employee.invoices.index')
                ->with('success', 'Invoice created successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient', 'appointment']);
        return view('Employee.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $patients = $this->invoiceService->getPatients();
        $appointments = $this->invoiceService->getAvailableAppointments($invoice->id);

        return view(
            'Employee.invoices.edit',
            compact('invoice', 'patients', 'appointments')
        );
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        DB::beginTransaction();
        try {
            $this->invoiceService->update(
                $invoice,
                $request->validated()
            );
            DB::commit();

            return redirect()
                ->route('employee.invoices.index')
                ->with('success', 'Invoice updated successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with('success', 'Invoice deleted successfully');
    }
}
