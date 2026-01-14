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


// Admin controller responsible for displaying , editing and deleting doctor records

class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function index()
    {
        try{
        $doctors = $this->doctorService->getAll();
        return view('Admin.doctors.index',compact('doctors'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load doctors');
        }
    }


    public function create()
    {
        try{
        $users = $this->doctorService->getUsers();
        return view('Admin.doctors.create', compact('users'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to create doctor page');
        }
    }


    public function store(StoreDoctorRequest $request)
    {
       try{
        $data = $request->validated();
        $doctor=$this->doctorService->store($data);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor created successfully');
       }
       catch (\Exception $e) {
        return back()->with('error', 'Failed to create doctor');
    }
    }


    // display all appointments for each doctor
    public function show($id)
{
    try{
    $doctor = Doctor::with('appointments.patient.user')->findOrFail($id);
    return view('Admin.doctors.schedule', compact('doctor'));
    }
    catch (\Exception $e) {
    return back()->with('error', 'Doctor not found');
    }
  }


    public function edit(Doctor $doctor)
    {
        try{
        $users = $this->doctorService->getUsers();
        return view('Admin.doctors.edit',compact('doctor','users'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to load edit page');
        }
    }


    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        try{
        $data = array_filter($request->validated(), fn($value) => !is_null($value));
        $this->doctorService->update($doctor, $data);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor updated successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to update doctor');
        }
    }



    public function destroy(Doctor $doctor)
    {
        try{
        $this->doctorService->delete($doctor);
        return  redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully');
        }
        catch (\Exception $e) {
            return back()->with('error', 'Failed to delete doctor');
        }
    }

   

  
    
}
