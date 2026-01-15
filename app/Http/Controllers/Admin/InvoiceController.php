<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Services\Admin\InvoiceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    /**
     * InvoiceController constructor.
     *
     * @param InvoiceService $invoiceService Service responsible for invoice operations
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a paginated list of invoices.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $invoices = $this->invoiceService->getAll()->paginate(10);
            return view('Admin.invoices.index', compact('invoices'));
        } catch (\Throwable $e) {
            Log::error('Fetching invoices failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to fetch invoices.']);
        }
    }

    /**
     * Show the form to create a new invoice.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            $patients = $this->invoiceService->getPatients();
            $appointments = $this->invoiceService->getAppointments();
            return view('Admin.invoices.create', compact('patients', 'appointments'));
        } catch (\Throwable $e) {
            Log::error('Load invoice create form failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load create invoice form.']);
        }
    }

    /**
     * Store a newly created invoice in the database.
     *
     * @param StoreInvoiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreInvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $this->invoiceService->store($data);
            DB::commit();

            return redirect()->route('admin.invoices.index')
                             ->with('success', 'Invoice created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Store invoice failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create invoice.'])->withInput();
        }
    }

    /**
     * Display the specified invoice.
     *
     * @param Invoice $invoice
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Invoice $invoice)
    {
        try {
            $invoice->load(['patient', 'appointment']);
            return view('Admin.invoices.show', compact('invoice'));
        } catch (\Throwable $e) {
            Log::error('Show invoice failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to display invoice.']);
        }
    }

    /**
     * Show the form for editing the specified invoice.
     *
     * @param Invoice $invoice
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Invoice $invoice)
    {
        try {
            $patients = $this->invoiceService->getPatients();
            $appointments = $this->invoiceService->getAppointments();
            return view('Admin.invoices.edit', compact('invoice', 'patients', 'appointments'));
        }
         catch (\Throwable $e) {
            Log::error('Load invoice edit form failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to load edit invoice form.']);
        }
    }

    /**
     * Update the specified invoice in the database.
     *
     * @param UpdateInvoiceRequest $request
     * @param Invoice $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        DB::beginTransaction();
        try {
            $data = array_filter($request->validated(), fn($value) => !is_null($value));
            $this->invoiceService->update($invoice, $data);
            DB::commit();

            return redirect()->route('admin.invoices.index')
                             ->with('success', 'Invoice updated successfully.');
        } 
        catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update invoice failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update invoice.'])->withInput();
        }
    }

    /**
     * Delete the specified invoice from the database.
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

            return back()->with('success', 'Invoice deleted successfully.');
        }
         catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delete invoice failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete invoice.']);
        }
    }
}
