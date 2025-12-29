<?php

namespace App\Services\Doctor;

use App\Models\Reservation;

class ReservationService
{
    public function getAll()
    {
        return Reservation::with('patient')
            ->latest()
            ->get();
    }

    public function store(array $data)
    {
        return Reservation::create($data);
    }

    public function update(Reservation $reservation, array $data)
    {
        $reservation->update($data);
        return $reservation;
    }

    public function delete(Reservation $reservation)
    {
        return $reservation->delete();
    }
}