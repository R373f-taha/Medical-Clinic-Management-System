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

    Route::post('/register', [PatientController::class, 'register']);

    Route::post('/login', [PatientController::class,'login']);

    Route::post('/refresh', [PatientController::class,'refresh']);

    Route::get('invoice/for/{id}/appointment', [AppointmentController::class,'invoice']);


});


Route::prefix('patient')->middleware(['auth:api'])->group(function () {
    Route::get('/me', [PatientController::class,'me']);
});

Route::prefix('patient')->middleware('auth:api')->group(function () {

    Route::middleware(['role:patient'])->group(function () {


    Route::get('/logout', [PatientController::class,'logout']);});


    Route::post('/take/appointment', [AppointmentController::class,'takeAppointment'])->middleware(['role:patient','permission:api:book appointment']);



Route::middleware(['auth:api'])->group(function () {
    Route::get('show/appointments', [AppointmentController::class,'show_appointments']);
});

    Route::middleware(['role:patient','permission:api:cancel own appointments'])->group(function () {


    Route::get('cancel/{id}/appointment', [AppointmentController::class,'cancel_appointment']);

    Route::get('cancel/appointments', [AppointmentController::class,'cancel_all_appointments']);});

    Route::middleware(['role:patient' ,'permission:api:view own medical record'])->group(function () {


    Route::get('/medicalRecord', [AppointmentController::class,'showMedicalRecord']);});

    Route::middleware(['role:patient','permission:api:view own prescriptions'])->group(function () {


    Route::get('get/prescriptions/for/{id}/medical/record', [AppointmentController::class,'prescriptions']);});

    Route::middleware(['role:patient','permission:create rating'])->group(function () {


  });

      Route::post('add/rating', [RatingController::class,'addRating'])->middleware(['role:patient','permission:api:book appointment']);


});
