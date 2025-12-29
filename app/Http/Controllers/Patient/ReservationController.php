<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\Patient\ReservationService;
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
        return response()->json($this->reservationService->getAll());
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'status'    => 'required|string|max:50',
        ]);

        $reservation = $this->reservationService->store($data);

        return response()->json([
            'message' => 'تم إنشاء الحجز بنجاح',
            'data' => $reservation
        ]);
    }

    public function show(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    public function update(Request $request, Reservation $reservation)
    {
         $data=$request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'status'    => 'required|string|max:50',
        ]);

        $reservation = $this->reservationService->update($reservation, $data);

        return response()->json([
            'message' => 'تم تحديث الحجز',
            'data' => $reservation
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        $this->reservationService->delete($reservation);

        return response()->json([
            'message' => 'تم حذف الحجز'
        ]);
    }
}
