<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Services\Employee\BookingService;
use App\Http\Requests\Store\StoreBookingRequest;
use App\Http\Requests\Update\UpdateBookingRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $service;

    public function __construct(BookingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $bookings = Appointment::with(['patient.user', 'doctor.user'])
            ->orderBy('appointment_date')
            ->get();

        return view('Employee.Booking.index', compact('bookings'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors  = Doctor::with('user')->get();

        return view('Employee.Booking.create', compact('patients', 'doctors'));
    }

    public function store(StoreBookingRequest $request)
    {
        $this->service->createBooking($request->validated());

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function edit($id)
    {
        $booking = Appointment::findOrFail($id);
        return view('Employee.Booking.edit', compact('booking'));
    }

    public function update(UpdateBookingRequest $request, $id)
    {
        $this->service->updateBooking(
            $id,
            $request->appointment_date,
            $request->reason,
            $request->status
        );

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function approve($id)
    {
        $this->service->approve($id);
        return redirect()->back()->with('success', 'Booking approved.');
    }

    public function reject($id)
    {
        $this->service->reject($id);
        return redirect()->back()->with('success', 'Booking rejected.');
    }
}
