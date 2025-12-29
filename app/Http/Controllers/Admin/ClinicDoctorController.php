<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Clinic_Doctor;
use Illuminate\Http\Request;

class ClinicDoctorController extends Controller
{
  
    public function index()
    {
        $clinicDoctors = Clinic_Doctor::with(['clinic', 'doctor'])->latest()->get();

    }

 
    public function create()
    {
        $clinics = Clinic::all();
        $doctors = Doctor::all();

    }

    public function store(Request $request)
    {
        $request->validate([
            'clinic_id' => 'required|exists:clinic,id',
            'doctor_id' => 'required|exists:doctor,id',
        ]);

        Clinic_Doctor::create($request->all());

        return redirect()
            ->route('admin.clinic-doctors.index')
            ->with('success', 'تم ربط الطبيب بالعيادة بنجاح');
    }


    public function show(Clinic_Doctor $clinicDoctor)
    {
    }

  
    public function edit(Clinic_Doctor $clinicDoctor)
    {
        $clinics = Clinic::all();
        $doctors = Doctor::all();

    }

    public function update(Request $request, Clinic_Doctor $clinicDoctor)
    {
        $request->validate([
            'clinic_id' => 'required|exists:clinic,id',
            'doctor_id' => 'required|exists:doctor,id',
        ]);

        $clinicDoctor->update($request->all());

        return redirect()
            ->route('admin.clinic-doctors.index')
            ->with('success', 'تم تعديل الرابط');
    }

   
    public function destroy(Clinic_Doctor $clinicDoctor)
    {
        $clinicDoctor->delete();

        return back()->with('success', 'تم حذف الرابط');
    }
}
