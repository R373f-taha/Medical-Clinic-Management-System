<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminMedicalRecordService;
use Exception;

class AdminMedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(AdminMedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
    }

    /**
     * Show all medical records
     */
    public function index()
    {
        try {
            $records = $this->medicalRecordService->getAll();

            return view('admin.medical_records.index', compact('records'));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed');
        }
    }

    /**
     * delete medical record
     */
    public function destroy($id)
    {
        try {
            $record = $this->medicalRecordService->findById($id);
            $this->medicalRecordService->delete($record);

            return redirect()->route('admin.medical-records.index')
                ->with('success', 'Delete Successfuly');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Delete Failed');
        }
    }
}
