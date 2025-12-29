<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
 
    public function index()
    {
        $invoices = Invoice::with(['patient', 'doctor'])->latest()->get();
    }

 
    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
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

   Invoice::create($data);
       

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
        $patients = Patient::all();
        $doctors = Doctor::all();
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

        $invoice->update($data);
  

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'تم تعديل الفاتورة');
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return back()->with('success', 'تم حذف الفاتورة');
    }
}
