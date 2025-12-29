<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with('patient')->latest()->get();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'patient_id'  => 'required|exists:users,id',
            'medicines'   => 'required|string',
            'notes'       => 'nullable|string',
        ]);

        Prescription::create($data);

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'تم إضافة الوصفة بنجاح');
    }

    public function show(Prescription $prescription)
    {
    }

    public function edit(Prescription $prescription)
    {
    }

    public function update(Request $request, Prescription $prescription)
    {
      $data=  $request->validate([
            'patient_id'  => 'required|exists:users,id',
            'medicines'   => 'required|string',
            'notes'       => 'nullable|string',
        ]);

        $prescription->update($data);

        return redirect()->route('doctor.prescriptions.index')
            ->with('success', 'تم تعديل الوصفة');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return back()->with('success', 'تم حذف الوصفة');
    }
}
