<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClinicRequest;
use App\Http\Requests\UpdateClinicRequest;
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

    public function create() {}

    public function store(StoreClinicRequest $request)
    {
        $data = $request->validated();

        $this->clinicService->store($data);

        return redirect()
            ->route('admin.clinics.index')
            ->with('success', 'تم إضافة العيادة بنجاح');
    }

    public function show(Clinic $clinic) {}

    public function edit(Clinic $clinic) {}

    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

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
