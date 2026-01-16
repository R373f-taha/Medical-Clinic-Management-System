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

/**
 * ========================================================
 * PUBLIC ROUTES (No Authentication Required)
 * ========================================================
 */
Route::prefix('patient')->name('patient.')->group(function () {
    /**
     * Patient registration endpoint.
     */
    Route::post('/register', [PatientController::class, 'register']);

    /**
     * Patient login endpoint.
     */
    Route::post('/login', [PatientController::class, 'login']);

    /**
     * Refresh JWT token endpoint.
     */
    Route::post('/refresh', [PatientController::class, 'refresh']);

    /**
     * View invoice for a specific appointment (public?).
     */
    Route::get('invoice/for/{id}/appointment', [AppointmentController::class, 'invoice']);
});

/**
 * ========================================================
 * AUTHENTICATED ROUTES (Requires API Authentication)
 * ========================================================
 */
Route::prefix('patient')->middleware(['auth:api'])->group(function () {
    /**
     * Get authenticated patient's profile.
     */
    Route::get('/me', [PatientController::class, 'me']);
});

/**
 * ========================================================
 * PATIENT-SPECIFIC ROUTES (Requires Patient Role)
 * ========================================================
 */
Route::prefix('patient')->middleware('auth:api')->group(function () {
    /**
     * Patient logout endpoint.
     */
    Route::middleware(['role:patient'])->group(function () {
        Route::get('/logout', [PatientController::class, 'logout']);
    });

    /**
     * Book a new appointment (requires specific permission).
     */
    Route::post('/take/appointment', [AppointmentController::class, 'takeAppointment'])->middleware(['role:patient', 'permission:api:book appointment']);

    /**
     * View patient's appointments.
     */
    Route::middleware(['auth:api'])->group(function () {
        Route::get('show/appointments', [AppointmentController::class, 'show_appointments']);
    });

    /**
     * Cancel appointment(s) (requires specific permission).
     */
    Route::middleware(['role:patient', 'permission:api:cancel own appointments'])->group(function () {
        Route::get('cancel/{id}/appointment', [AppointmentController::class, 'cancel_appointment']);
        Route::get('cancel/appointments', [AppointmentController::class, 'cancel_all_appointments']);
    });

    /**
     * View medical record (requires specific permission).
     */
    Route::middleware(['role:patient', 'permission:api:view own medical record'])->group(function () {
        Route::get('/medicalRecord', [AppointmentController::class, 'showMedicalRecord']);
    });

    /**
     * View prescriptions for a medical record (requires specific permission).
     */
    Route::middleware(['role:patient', 'permission:api:view own prescriptions'])->group(function () {
        Route::get('get/prescriptions/for/{id}/medical/record', [AppointmentController::class, 'prescriptions']);
    });

    /**
     * Add rating (requires specific permission).
     */
    Route::post('add/rating', [RatingController::class, 'addRating'])->middleware(['role:patient', 'permission:api:book appointment']);
});
