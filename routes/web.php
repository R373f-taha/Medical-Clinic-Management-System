<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\ClinicDoctorController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AppointmentMonitorController;
use App\Http\Controllers\Admin\AdminMedicalRecordController;

use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\RatingController;
use App\Http\Controllers\Patient\ImageController;

use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Doctor\PrescriptionController;

use App\Http\Controllers\Employee\ScheduleController;
use App\Http\Controllers\Employee\BookingController;


use App\Http\Controllers\Admin\DoctorScheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Employee\EmployeeInvoiceController;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});







//  الخاص بمدير العيادة (Admin)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:clinicManager'])->group(function () {

    // إدارة الموارد
    Route::resources([
        'employees'      => EmployeeController::class,
        'clinics'        => ClinicController::class,
        'clinic-doctors' => ClinicDoctorController::class,
        'doctors'        => DoctorController::class,
        'invoices'       => InvoiceController::class,
        'notifications'  => NotificationController::class,
    ]);

    // إدارة المواعيد
    Route::get('appointments', [AppointmentMonitorController::class, 'index'])->name('appointments.index');
    Route::delete('appointments/{id}', [AppointmentMonitorController::class, 'destroy'])->name('appointments.destroy');

    // إدارة بيانات العيادة
    Route::get('clinic-settings', [ClinicController::class, 'index'])->name('clinic.index');
    Route::get('clinic/{clinic}/edit', [ClinicController::class, 'edit'])->name('clinic.edit');
    Route::put('clinic/{clinic}', [ClinicController::class, 'update'])->name('clinic.update');


});








///////////////////////////////////////////////
Route::prefix('employee')->name('employee.')->middleware(['auth'])->group(function () {

    // ===== إدارة الحجوزات =====
    Route::middleware('permission:manage appointments')->group(function () {
        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
        Route::post('bookings/{id}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
        Route::post('bookings/{id}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::delete('bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::post('bookings/{id}/complete', [BookingController::class, 'complete'])->name('bookings.complete');
    });

    // ===== جدول الأطباء =====
    Route::get('schedule', [ScheduleController::class, 'index'])
        ->name('schedule')
        ->middleware('permission:manage doctors');
});




Route::prefix('patient')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    Route::resources([
        'profile'      => PatientController::class,
        'appointments' => PatientAppointmentController::class,
        'ratings'      => RatingController::class,
        'images'       => ImageController::class,
    ]);
});

/**/
Route::prefix('doctor')
    ->name('doctor.')
    ->middleware(['auth', 'role:doctor'])
    ->group(function () {

        // ================== Patients ==================
        Route::get('patients', [\App\Http\Controllers\Doctor\PatientController::class, 'index'])
            ->name('patients.index')
            ->middleware('permission:manage patients');

        // ==================  medical-records  ==================
        Route::prefix('medical-records')
            ->middleware('permission:manage medical records')
            ->group(function () {

                Route::get('/', [MedicalRecordController::class, 'index'])->name('medical_records.index');
                Route::get('/create', [MedicalRecordController::class, 'create'])->name('medical_records.create');
                Route::post('/', [MedicalRecordController::class, 'store'])->name('medical_records.store');
                Route::get('{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical_records.edit');
                Route::put('{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical_records.update');
            });

        // ================== appointments ==================
        Route::prefix('appointments')
            ->middleware('permission:manage appointments')
            ->group(function () {

                Route::get('/', [\App\Http\Controllers\Doctor\AppointmentController::class, 'doctorAppointments'])
                    ->name('appointments.doctorAppointments');

                Route::get('/today', [\App\Http\Controllers\Doctor\AppointmentController::class, 'today'])
                    ->name('appointments.today');

                Route::get('/create', [\App\Http\Controllers\Doctor\AppointmentController::class, 'create'])
                    ->name('appointments.create');

                Route::post('/', [\App\Http\Controllers\Doctor\AppointmentController::class, 'store'])
                    ->name('appointments.store');

                Route::get('{appointment}/update', [\App\Http\Controllers\Doctor\AppointmentController::class, 'update'])
                    ->name('appointments.update');

                Route::put('{appointment}', [\App\Http\Controllers\Doctor\AppointmentController::class, 'Edit'])
                    ->name('appointments.edit');
            });
        // ================== prescriptions ==================
        Route::resource('prescriptions', PrescriptionController::class)
            ->middleware('permission:manage prescriptions');
        Route::get(
            '/doctor/prescriptions/{prescription}/download',
            [PrescriptionController::class, 'download']
        )->name('prescriptions.download');
    });


/*
Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {

    Route::get('doctor/patients', [App\Http\Controllers\Doctor\PatientController::class, 'index'])->name('patients.index');
    Route::get('doctor/medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class, 'index'])->name('medical_records.index');
    Route::get('doctor/create_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class, 'create'])->name('medical_records.create');
    Route::post('doctor/store_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class, 'store'])->name('medical_records.store');
    Route::get('doctor/{medicalRecord}/edit_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class, 'edit'])->name('medical_records.edit');
    Route::put('doctor/{medicalRecord}/update_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class, 'update'])->name('medical_records.update');

    Route::get('doctor/appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'doctorAppointments'])->name('appointments.doctorAppointments');
    Route::get('doctor/today_appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'today'])->name('appointments.today');
    Route::get('doctor/create_appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('doctor/store_appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('doctor/{appointment}/update_appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'update'])->name('appointments.update');
    Route::put('doctor/{appointment}/edit_appointments', [App\Http\Controllers\Doctor\AppointmentController::class, 'edit'])->name('appointments.edit');
});
*/


Route::prefix('employee')->name('employee.')
    ->middleware(['auth', 'role:employee'])->group(function () {
        Route::resource('invoices', EmployeeInvoiceController::class);
    });



// Auth routes
require __DIR__ . '/auth.php';




