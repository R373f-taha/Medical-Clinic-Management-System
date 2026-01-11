<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\Employee\BookingService;
use App\Http\Requests\Store\StoreBookingRequest;
use App\Http\Requests\Update\UpdateBookingRequest;

class BookingController extends Controller
{
    protected $service;

    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    // عرض كل الحجوزات
    public function index()
    {
        $bookings = Appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date')
            ->get();

        return view('Employee.Booking.index', compact('bookings'));
    }

    // صفحة إنشاء موعد جديد
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors  = Doctor::with('user')->get();

        return view('Employee.Booking.create', compact('patients', 'doctors'));
    }

    // حفظ موعد جديد
    public function store(StoreBookingRequest $request)
    {
        $this->service->createBooking($request->validated());

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    // صفحة تعديل موعد
    public function edit($id)
    {
        $booking = Appointment::findOrFail($id);
        return view('Employee.Booking.edit', compact('booking'));
    }

    // تحديث موعد (تعديل الوقت أو السبب)
    public function update(UpdateBookingRequest $request, $id)
    {
        $this->service->updateBooking(
            $id,
            $request->appointment_date,
            $request->reason
        );

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    // الموافقة على طلب حجز
    public function approve($id)
    {
        $this->service->approve($id);
        return redirect()->back()->with('success', 'Booking approved.');
    }

    // رفض طلب حجز
    public function reject($id)
    {
        $this->service->reject($id);
        return redirect()->back()->with('success', 'Booking rejected.');
    }

    // حذف موعد
    public function destroy($id)
    {
        Appointment::findOrFail($id)->delete();

        return redirect()->back()
            ->with('success', 'Booking deleted successfully.');
    }

    // تحديد موعد مكتمل
    public function complete($id)
    {
        $this->service->complete($id);

        return redirect()->back()->with('success', 'Booking marked as completed.');
    }
}
