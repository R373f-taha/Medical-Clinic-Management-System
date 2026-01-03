<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
//use App\Http\Requests\StoreMedicalRecordRequest;
//use App\Http\Requests\Store\StoreMedicalRecordRequest;
//use App\Http\Requests\StoreMedicalRecordRequest as RequestsStoreMedicalRecordRequest;
//use App\Http\Requests\StoreMedicalRecordRequest as RequestsStoreMedicalRecordRequest;

use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Http\Requests\ٍStore\StoreMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Services\Doctor\MedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $medicalRecordService;

    public function __construct(MedicalRecordService $medicalRecordService)
    {
        $this->medicalRecordService = $medicalRecordService;
    }

    public function index()
    {
        $records = $this->medicalRecordService->getAll();
    }

//     public function check(Request $request)
//     {
//         $patientId=$request->query("patient_id");

//         if(!$patientId){
//             return response()->json(['error'=>'المويض مش موجود']);
//         }
//          $patient=Patient::find($patientId);

//         if($patient->expiresAt->diffInMinutes(now()) > 10){

//             $patient->delete();
//             return response()->json(['error'=> 'انتهت المهلة. تم حذف المريض'],404);

//     }
//     return  response()->json([
//         'testing'=>'yes you can get a special medical record for you',
//         'add_medical_record_url' => url('/api/store-medical-record?patient_id=' . $patient->id),
//      //   'add_medical_record_url' => url('/api/medical-records/create?patient_id=' . $patient->id),
//         'instructions' => 'أرسل POST request إلى الرابط أعلاه مع بيانات السجل الطبي'
//     ],200);

// }
    public function store(\App\Http\Requests\Store\StoreMedicalRecordRequest $request)
    {

    
        $data = $request->validated();


        $medicalRecord=$this->medicalRecordService->store($data);


          return response()->json([
            'message' => 'تم إضافة السجل الطبي بنجاح',
            'data' => $medicalRecord,
          //  'patient_url' => route('patients.show', $medicalRecord->patient_id)
        ], 201);
    }

    public function show(MedicalRecord $medicalRecord) {}

    public function edit(MedicalRecord $medicalRecord) {}

    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $this->medicalRecordService->update($medicalRecord, $data);

        return redirect()
            ->route('doctor.medical-records.index')
            ->with('success', 'تم تعديل السجل الطبي');
    }


    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->medicalRecordService->delete($medicalRecord);
        return back()->with('success', 'تم حذف السجل الطبي');
    }
}
