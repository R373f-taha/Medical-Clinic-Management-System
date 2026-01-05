<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Update\UpdateDoctorRequest;
use App\Http\Requests\Store\StoreDoctorRequest;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use App\Services\Admin\DoctorService;
use Illuminate\Http\Request;



class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        $doctors = $this->doctorService->getAll();
        return view('Admin.doctors.index',compact('doctors'));
    }


    public function create()
    {
        $users = $this->doctorService->getUsers();
        return view('Admin.doctors.create', compact('users'));
    }


    public function store(StoreDoctorRequest $request)
    {
       
        $data = $request->validated();

        $this->doctorService->store($data);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }


    public function show($id)
{
    $doctor = Doctor::with('appointments.patient.user')->findOrFail($id);

    return view('Admin.doctors.schedule', compact('doctor'));
}


    public function edit(Doctor $doctor)
    {
        $users = $this->doctorService->getUsers();
        return view('Admin.doctors.edit',compact('doctor','users'));
    }


    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $this->doctorService->update($doctor, $data);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'تم تعديل بيانات الطبيب');
    }



    public function destroy(Doctor $doctor)
    {
        $this->doctorService->delete($doctor);
        return  redirect()->route('doctors.index')->with('success', 'تم حذف الطبيب');
    }

   

  
    
}
