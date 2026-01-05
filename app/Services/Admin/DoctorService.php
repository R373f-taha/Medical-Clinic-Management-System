<?php

namespace App\Services\Admin;

use App\Models\Doctor;
use App\Models\User;

class DoctorService
{
    public function getAll()
    {
        return Doctor::with('user')
            ->latest()
            ->get();
    }

    public function getUsers()
    {
        return User::all();
    }

    public function store(array $data)
    {
        
        return Doctor::create($data);
    }

    public function update(Doctor $doctor, array $data)
    {
        $doctor->update($data);
        return $doctor;
    }

    public function delete(Doctor $doctor)
    {
        return $doctor->delete();
    }
}