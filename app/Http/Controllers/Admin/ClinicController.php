<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Services\Admin\ClinicService;
use App\Http\Requests\Update\UpdateClinicRequest;

class ClinicController extends Controller
{
    protected ClinicService $clinicService;

    public function __construct(ClinicService $clinicService)
    {
        $this->clinicService = $clinicService;
    }

    // عرض بيانات العيادة
    public function index()
    {
        $clinic = $this->clinicService->get();
        return view('admin.Clinic.index', compact('clinic'));
    }

    // تعديل بيانات العيادة
    public function edit(Clinic $clinic)
    {
        return view('admin.Clinic.edit', compact('clinic'));
    }

    // حفظ التعديلات
    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $this->clinicService->update($clinic, $request->validated());

        return redirect()->route('admin.clinic.index')
                         ->with('success', 'تم تعديل بيانات العيادة بنجاح');
    }
}
