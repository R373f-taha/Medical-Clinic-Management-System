<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('patient')->latest()->get();
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

        Reservation::create($data());

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

        $reservation->update($data);

        return redirect()->route('doctor.reservations.index')
            ->with('success', 'تم تعديل الحجز');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return back()->with('success', 'تم حذف الحجز');
    }
}
