<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
 
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->get();
    }

  
    public function create()
    {
        $users = User::all(); 
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'specialty' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string',
        ]);

        Doctor::create($request->all());

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم إضافة الطبيب بنجاح');
    }

  
    public function show(Doctor $doctor)
    {
    }

 
    public function edit(Doctor $doctor)
    {
        $users = User::all();
    }

   
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'specialty' => 'required|string|max:255',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string',
        ]);

        $doctor->update($request->all());

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'تم تعديل بيانات الطبيب');
    }

  
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success', 'تم حذف الطبيب');
    }
}
