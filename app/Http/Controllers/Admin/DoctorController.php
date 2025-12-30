<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
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


    public function store(StoreDoctorRequest $request)
    {
        $data = $request->validated();

        $this->doctorService->store($data);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }


    public function show(Doctor $doctor) {}


    public function edit(Doctor $doctor)
    {
        $users = $this->doctorService->getUsers();
    }


    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $this->doctorService->update($doctor, $data);

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
