<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;

class AdminMedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with([
                'doctor.user',
                'patient.user'
            ])
            ->latest()
            ->paginate(10);

        return view('admin.medical_records.index', compact('records'));
    }
}
