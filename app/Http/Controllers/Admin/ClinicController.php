<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Services\Admin\ClinicService;
use App\Http\Requests\Update\UpdateClinicRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            $clinic = $this->clinicService->get();
            return view('admin.Clinic.index', compact('clinic'));
        } 
        catch (\Throwable $e) {
            Log::error('Fetching clinic failed: '.$e->getMessage());
            return back()->withErrors(['error' => 'Unable to fetch clinic data.']);
        }
    }

    // صفحة تعديل بيانات العيادة
    public function edit(Clinic $clinic)
    {
        return view('admin.Clinic.edit', compact('clinic'));
    }

    // حفظ التعديلات
    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        DB::beginTransaction();
        try {
            $this->clinicService->update($clinic, $request->validated());
            DB::commit();

            return redirect()->route('admin.clinic.index')
                             ->with('success', 'Clinic data updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Update clinic failed: '.$e->getMessage());

            return back()->withErrors(['error' => 'Failed to update clinic data.'])->withInput();
        }
    }
}
