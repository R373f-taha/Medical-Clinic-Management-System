<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
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

    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();

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

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $data = array_filter($request->validated(), fn($value) => !is_null($value));

        $reservation = $this->reservationService->update($reservation, $data);

        return response()->json([
            'message' => 'تم تحديث الحجز',
            'data'    => $reservation
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
