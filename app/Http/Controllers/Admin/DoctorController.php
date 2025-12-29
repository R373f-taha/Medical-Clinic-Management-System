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
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'specialty' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string',
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
            'user_id'   => 'required|exists:users,id',
            'specialty' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string',
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
