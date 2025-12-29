<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Clinic_Doctor;
use App\Services\Admin\ClinicDoctorService;
use Illuminate\Http\Request;

class ClinicDoctorController extends Controller
{
    protected $clinicDoctorService;

    public function __construct(ClinicDoctorService $clinicDoctorService)
    {
        $this->clinicDoctorService = $clinicDoctorService;
    }
  
    public function index()
    {
        $clinicDoctors = $this->clinicDoctorService->getAll();

    }

 
    public function create()
    {
        $clinics = $this->clinicDoctorService->getClinics();
        $doctors = $this->clinicDoctorService->getDoctors();

    }

    public function store(Request $request)
    {
        $request->validate([
            'clinic_id' => 'required|exists:clinic,id',
            'doctor_id' => 'required|exists:doctor,id',
        ]);

        $this->clinicDoctorService->store($request->all());

        return redirect()
            ->route('admin.clinic-doctors.index')
            ->with('success', 'تم ربط الطبيب بالعيادة بنجاح');
    }


    public function show(Clinic_Doctor $clinicDoctor)
    {
    }

  
    public function edit(Clinic_Doctor $clinicDoctor)
    {
        $clinics = $this->clinicDoctorService->getClinics();
        $doctors = $this->clinicDoctorService->getDoctors();

    }

    public function update(Request $request, Clinic_Doctor $clinicDoctor)
    {
        $request->validate([
            'clinic_id' => 'required|exists:clinic,id',
            'doctor_id' => 'required|exists:doctor,id',
        ]);

        $this->clinicDoctorService->update($clinicDoctor, $request->all());

        return redirect()
            ->route('admin.clinic-doctors.index')
            ->with('success', 'تم تعديل الرابط');
    }

   
    public function destroy(Clinic_Doctor $clinicDoctor)
    {
        $this->clinicDoctorService->delete($clinicDoctor);

        return back()->with('success', 'تم حذف الرابط');
    }
}
