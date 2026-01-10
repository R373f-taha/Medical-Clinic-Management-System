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

     Route::post('/register', [PatientController::class, 'register']);

     Route::get('/login', [PatientController::class,'login']);

    Route::get('/refresh', [PatientController::class,'refresh']);

    Route::get('invoice/for/{id}/appointment', [AppointmentController::class,'invoice']);


});

Route::prefix('patient')->middleware('auth:api')->group(function () {

    Route::get('/me', [PatientController::class,'me']);

    Route::get('/logout', [PatientController::class,'logout']);

    Route::post('/take/appointment', [AppointmentController::class,'takeAppointment']);

    Route::get('show/appointments', [AppointmentController::class,'show_appointments']);

    Route::get('cancel/{id}/appointment', [AppointmentController::class,'cancel_appointment']);

    Route::get('cancel/appointments', [AppointmentController::class,'cancel_all_appointments']);

    Route::get('/medicalRecord', [AppointmentController::class,'showMedicalRecord']);

    Route::get('get/prescriptions/for/{id}/medical/record', [AppointmentController::class,'prescriptions']);

    Route::post('add/rating', [RatingController::class,'addRating']);





});
