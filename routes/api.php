<?php

use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Doctor\PrescriptionController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\ImageController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;


Route::prefix('patient')->name('patient.')->group(function () {

    Route::apiResource('patients', PatientController::class);

    Route::apiResource('prescriptions', PrescriptionController::class);

    Route::apiResource('medical-records', MedicalRecordController::class);

    Route::apiResource('appointments', AppointmentController::class);

    Route::apiResource('images', ImageController::class);

    Route::apiResource('ratings', RatingController::class);



});


