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
        if(isset($data['services']) && is_string($data['services'])) {
            $data['services'] = array_filter(array_map('trim', explode('،', $data['services'])));
        }
        
        return Doctor::create($data);
    }

    public function update(Doctor $doctor, array $data)
    {
        if(isset($data['services'])) {
            
            $data['services'] = array_filter(
                array_map('trim', explode('،', $data['services']))
            );
        }
    
        $doctor->update($data);
        return $doctor;
    }

    public function delete(Doctor $doctor)
    {
        return $doctor->delete();
    }
}