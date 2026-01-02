<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\ClinicDoctorController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\ReservationController;
use App\Http\Controllers\Patient\RatingController;
use App\Http\Controllers\Patient\ImageController;

use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Doctor\PrescriptionController;

use App\Http\Controllers\Employee\ScheduleController;
use App\Http\Controllers\Employee\BookingController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});//->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
    Route::resources([
        'clinics'        => ClinicController::class,
        'clinic-doctors' => ClinicDoctorController::class,
        'doctors'        => DoctorController::class,
        'employees'      => EmployeeController::class,
        'invoices'       => InvoiceController::class,
        'notifications'  => NotificationController::class,
    ]);
});

Route::prefix('patient')->name('patient.')->middleware(['auth','role:patient'])->group(function () {
    Route::resources([
        'profile'      => PatientController::class,
        'appointments' => PatientAppointmentController::class,
        'reservations' => ReservationController::class,
        'ratings'      => RatingController::class,
        'images'       => ImageController::class,
    ]);
});

Route::prefix('doctor')->name('doctor.')->middleware(['auth','role:doctor'])->group(function () {
    Route::resources([
        'medical-records'  => MedicalRecordController::class,
        'prescriptions'    => PrescriptionController::class,
    ]);
});

// Employee Resources (Schedules + Bookings)
Route::prefix('employee')->name('employee.')->middleware(['auth','role:employee'])->group(function () {
    Route::resources([
        'schedules' => ScheduleController::class,
        'bookings'  => BookingController::class,
    ]);
});

// Auth routes
require __DIR__.'/auth.php';
