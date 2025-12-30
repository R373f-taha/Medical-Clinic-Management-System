<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
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
    }

  
    public function create()
    {
        $users = $this->doctorService->getUsers();
    }

 
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'specialization'    => 'required|string|max:255',
            'qualifications'    => 'required|string|max:255',
            'available_hours'   => 'required|integer|min:0',
            'experience_years'  => 'nullable|integer|min:0',
            'Current_rate'      => 'required|integer|min:0',
        ]);

        $this->doctorService->store($request->all());

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }

  
    public function show(Doctor $doctor)
    {
    }

 
    public function edit(Doctor $doctor)
    {
        $users = $this->doctorService->getUsers();
    }

   
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
         'user_id'           => 'required|exists:users,id',
            'specialization'    => 'required|string|max:255',
            'qualifications'    => 'required|string|max:255',
            'available_hours'   => 'required|integer|min:0',
            'experience_years'  => 'nullable|integer|min:0',
            'Current_rate'      => 'required|integer|min:0',
        ]);

        $this->doctorService->update($doctor, $request->all());

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم تعديل بيانات الطبيب');
    }

  
    public function destroy(Doctor $doctor)
    {
        $this->doctorService->delete($doctor);
        return back()->with('success', 'تم حذف الطبيب');
    }
}
