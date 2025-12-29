<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return response()->json(Reservation::latest()->get());
    }

    public function store(Request $request)
    {
       $data= $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'date'      => 'required|date',
            'time'      => 'required',
            'status'    => 'required|string|max:50',
        ]);

        $reservation = Reservation::create($data);

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

        $reservation->update($data);

        return response()->json([
            'message' => 'تم تحديث الحجز',
            'data' => $reservation
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'message' => 'تم حذف الحجز'
        ]);
    }
}
