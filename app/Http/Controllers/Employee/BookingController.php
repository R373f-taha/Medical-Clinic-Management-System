<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\UpdateBookingRequest;
use App\Models\Appointment;
use App\Services\Employee\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * عرض جميع الحجوزات
     */
    public function index()
    {
        return $this->bookingService->getAll();
    }

    /**
     * تحديث الحجز
     */
    public function update(UpdateBookingRequest $request, Appointment $appointment)
    {
        $appointment = $this->bookingService->update(
            $appointment,
            $request->validated()
        );

        return response()->json([
            'message' => 'تم تحديث الحجز بنجاح',
            'data'    => $appointment,
        ]);
    }

    /**
     * قبول الحجز
     */
    public function approve(Appointment $appointment)
    {
        $appointment = $this->bookingService->approve($appointment);

        return response()->json([
            'message' => 'تم قبول الحجز',
            'data'    => $appointment,
        ]);
    }

    /**
     * رفض الحجز
     */
    public function reject(Appointment $appointment)
    {
        $appointment = $this->bookingService->reject($appointment);

        return response()->json([
            'message' => 'تم رفض الحجز',
            'data'    => $appointment,
        ]);
    }
}
