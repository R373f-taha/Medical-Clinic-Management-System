<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\ClinicDoctorController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\AppointmentMonitorController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
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
// testing doctor dashboard...
Route::get('doctor/dashboard', [DoctorDashboardController::class, 'index'])->name('doctor.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () {
//     Route::resources([
//         'clinics'        => ClinicController::class,
//         'clinic-doctors' => ClinicDoctorController::class,
//         'doctors'        => DoctorController::class,
//         'employees'      => EmployeeController::class,
//         'invoices'       => InvoiceController::class,
//         'notifications'  => NotificationController::class,
//     ]);
// });
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('employees', EmployeeController::class);
});

Route::prefix('admin') ->name('admin.') ->group(function () {

        Route::get('AppointmentMonitor',
        [AppointmentMonitorController::class, 'index'])->name('AppointmentMonitor.index');

        Route::delete('AppointmentMonitor/{appointment}',
[AppointmentMonitorController::class, 'destroy'] )->name('AppointmentMonitor.destroy');

    });






Route::prefix('admin')->name('admin.')->group(function () {
    // عرض بيانات العيادة
    Route::get('clinic', [ClinicController::class, 'index'])->name('clinic.index');

    // تعديل بيانات العيادة
    Route::get('clinic/{clinic}/edit', [ClinicController::class, 'edit'])->name('clinic.edit');

    // حفظ التعديلات
    Route::put('clinic/{clinic}', [ClinicController::class, 'update'])->name('clinic.update');
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
// Temp Routes for testing doctor baldes...
Route::get('doctor/patients', [App\Http\Controllers\Doctor\PatientController::class,'index'])->name('doctor.patients.index');
Route::get('doctor/medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class,'index'])->name('doctor.medical_records.index');
Route::get('doctor/create_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class,'create'])->name('doctor.medical_records.create');
Route::post('doctor/store_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class,'store'])->name('doctor.medical_records.store');
Route::get('doctor/{medicalRecord}/edit_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class,'edit'])->name('doctor.medical_records.edit');
Route::put('doctor/{medicalRecord}/update_medical_records', [App\Http\Controllers\Doctor\MedicalRecordController::class,'update'])->name('doctor.medical_records.update');

Route::get('doctor/appointments', [App\Http\Controllers\Doctor\AppointmentController::class,'doctorAppointments'])->name('doctor.appointments.doctorAppointments');
Route::get('doctor/today_appointments', [App\Http\Controllers\Doctor\AppointmentController::class,'today'])->name('doctor.appointments.today');
Route::get('doctor/create_appointments', [App\Http\Controllers\Doctor\AppointmentController::class,'create'])->name('doctor.appointments.create');
Route::post('doctor/store_appointments', [App\Http\Controllers\Doctor\AppointmentController::class,'store'])->name('doctor.appointments.store');
Route::get('doctor/{appointment}/update_appointments', [App\Http\Controllers\Doctor\AppointmentController::class,'update'])->name('doctor.appointments.update');
Route::put('doctor/{appointment}/edit_appointments', [App\Http\Controllers\Doctor\AppointmentController::class,'edit'])->name('doctor.appointments.edit');


// Auth routes
require __DIR__.'/auth.php';
