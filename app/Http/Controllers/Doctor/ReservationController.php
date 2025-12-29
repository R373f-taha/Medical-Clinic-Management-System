<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\Doctor\ReservationService;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $reservations = $this->reservationService->getAll();
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data=$request->validate([
            'patient_id' => 'required|exists:users,id',
            'date'       => 'required|date',
            'time'       => 'required',
            'status'     => 'required|string|max:50',
        ]);

        $this->reservationService->store($data);

        return redirect()->route('doctor.reservations.index')
            ->with('success', 'تم إضافة الحجز بنجاح');
    }

    public function show(Reservation $reservation)
    {
    }

    public function edit(Reservation $reservation)
    {
    }

    public function update(Request $request, Reservation $reservation)
    {
       $data= $request->validate([
            'patient_id' => 'required|exists:users,id',
            'date'       => 'required|date',
            'time'       => 'required',
            'status'     => 'required|string|max:50',
        ]);

         $this->reservationService->update($reservation, $data);

        return redirect()->route('doctor.reservations.index')
            ->with('success', 'تم تعديل الحجز');
    }

    public function destroy(Reservation $reservation)
    {
        $this->reservationService->delete($reservation);

        return back()->with('success', 'تم حذف الحجز');
    }
}
