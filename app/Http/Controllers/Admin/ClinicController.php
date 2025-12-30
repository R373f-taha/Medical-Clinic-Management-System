<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Services\Admin\ClinicService;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    protected ClinicService $clinicService;

    public function __construct(ClinicService $clinicService)
    {
        $this->clinicService = $clinicService;
    }

    public function index()
    {
        $clinics = $this->clinicService->getAll();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
        ]);

        $this->clinicService->store($data);

        return redirect()
            ->route('admin.clinics.index')
            ->with('success', 'تم إضافة العيادة بنجاح');
    }

    public function show(Clinic $clinic)
    {

        }

    public function edit(Clinic $clinic)
    {
    }

    public function update(Request $request, Clinic $clinic)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
        ]);

        $this->clinicService->update($clinic, $data);

        return redirect()
            ->route('admin.clinics.index')
            ->with('success', 'تم تعديل العيادة بنجاح');
    }

    public function destroy(Clinic $clinic)
    {
        $this->clinicService->delete($clinic);

        return redirect()
            ->route('admin.clinics.index')
            ->with('success', 'تم حذف العيادة بنجاح');
    }
}
