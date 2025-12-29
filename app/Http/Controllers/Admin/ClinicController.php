<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Services\Admin\ClinicService;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    protected $clinicService;
    public function __construct(ClinicService $clinicService)
    {
        $this->clinicService = $clinicService;
    }

    public function index()
    {
        $clinics =  $this->clinicService->getAll();

        return view('admin.clinics.index', compact('clinics'));
    }


    public function create()
    {
        return view('admin.clinics.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
        ]);

        $this->clinicService->store($request->all());

        return redirect()
            ->route('admin.clinics.index')
            ->with('success', 'تم إضافة العيادة بنجاح');
    }

   
    public function show(Clinic $clinic)
    {
        return view('admin.clinics.show', compact('clinic'));
    }

  
    public function edit(Clinic $clinic)
    {
        return view('admin.clinics.edit', compact('clinic'));
    }

  
    public function update(Request $request, Clinic $clinic)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
        ]);

        $this->clinicService->update($clinic, $request->all());

        return redirect()
            ->route('admin.clinics.index')
            ->with('success', 'تم تعديل العيادة');
    }


    public function destroy(Clinic $clinic)
    {
        $this->clinicService->delete($clinic);

        return back()->with('success', 'تم حذف العيادة');
    }
}
