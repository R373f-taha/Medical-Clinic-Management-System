<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\Admin\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

 
    public function index()
    {
         $invoices = $this->invoiceService->getAll();
    }

 
    public function create()
    {
        $patients = $this->invoiceService->getPatients();
        $doctors  = $this->invoiceService->getDoctors();
    }

  
    public function store(Request $request)
    {
       $data = $request->validate([
            'patient_id' => 'required|exists:patient,id',
            'doctor_id'  => 'required|exists:doctor,id',
            'amount'     => 'required|numeric',
            'status'     => 'required|string|max:50',
            'date'       => 'required|date',
        ]);

        $this->invoiceService->store($data);
       

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'تم إنشاء الفاتورة بنجاح');
    }

 
    public function show(Invoice $invoice)
    {
        $invoice->load(['patient','doctor']);
    }

   
    public function edit(Invoice $invoice)
    {
        $patients = $this->invoiceService->getPatients();
        $doctors  = $this->invoiceService->getDoctors();
    }


    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patient,id',
            'doctor_id'  => 'required|exists:doctor,id',
            'amount'     => 'required|numeric',
            'status'     => 'required|string|max:50',
            'date'       => 'required|date',
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
