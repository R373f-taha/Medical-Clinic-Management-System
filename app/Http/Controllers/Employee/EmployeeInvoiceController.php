<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\Admin\InvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;

class EmployeeInvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    /**
     * Constructor to inject the InvoiceService.
     *
     * @param InvoiceService $invoiceService
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of invoices.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $invoices = $this->invoiceService->getAll()->paginate(10);
            return view('Employee.invoices.index', compact('invoices'));
        } catch (\Throwable $e) {
            Log::error('Fetching invoices failed: '.$e->getMessage());
            return back()->withErrors(['error' => 'Unable to fetch invoices.']);
        }
    }

    /**
     * Show the form for creating a new invoice.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try {
            $patients = $this->invoiceService->getPatients();
            $appointments = Appointment::whereDoesntHave('invoice')->get();
            return view('Employee.invoices.create', compact('patients', 'appointments'));
        } catch (\Throwable $e) {
            Log::error('Fetching create invoice data failed: '.$e->getMessage());
            return back()->withErrors(['error' => 'Unable to load create invoice form.']);
        }
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param StoreInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->invoiceService->store($request->validated());
            DB::commit();

            return redirect()->route('employee.invoices.index')
                             ->with('success', 'Invoice created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Create invoice failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to create invoice.'])->withInput();
        }
    }

    /**
     * Display the specified invoice.
     *
     * @param Invoice $invoice
     * @return \Illuminate\View\View
     */
    public function show(Invoice $invoice)
    {
        try {
            $invoice->load('patient.user', 'appointment');
            return view('Employee.invoices.show', compact('invoice'));
        } catch (\Throwable $e) {
            Log::error('Show invoice failed: '.$e->getMessage());
            return back()->withErrors(['error' => 'Unable to display invoice.']);
        }
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param Invoice $invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        try {
            $patients = $this->invoiceService->getPatients();
            $appointments = $this->invoiceService->getAppointments();
            return view('Employee.invoices.edit', compact('invoice', 'patients', 'appointments'));
        } catch (\Throwable $e) {
            Log::error('Edit invoice failed: '.$e->getMessage());
            return back()->withErrors(['error' => 'Unable to load edit form.']);
        }
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param UpdateInvoiceRequest $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        DB::beginTransaction();
        try {
            $this->invoiceService->update($invoice, $request->validated());
            DB::commit();

            return redirect()->route('employee.invoices.index')
                             ->with('success', 'Invoice updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update invoice failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to update invoice.'])->withInput();
        }
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Invoice $invoice)
    {
        DB::beginTransaction();
        try {
            $this->invoiceService->delete($invoice);
            DB::commit();

            return redirect()->route('employee.invoices.index')
                             ->with('success', 'Invoice deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete invoice failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to delete invoice.']);
        }
    }
}
