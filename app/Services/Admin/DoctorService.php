<?php

namespace App\Services\Admin;

use App\Models\Doctor;
use App\Models\User;

class DoctorService
{
    /**
     * Retrieve all doctors with their associated user information.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Doctor::with('user')->latest()->get();
    }

    /**
     * Retrieve all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsers()
    {
        return User::all();
    }

    /**
     * Store a new doctor record.
     * Converts services string to an array if provided.
     *
     * @param array $data
     * @return \App\Models\Doctor
     */
    public function store(array $data)
    {
        if (isset($data['services']) && is_string($data['services'])) {
            $data['services'] = array_filter(array_map('trim', explode('،', $data['services'])));
        }
        return Doctor::create($data);
    }

    /**
     * Update a doctor's record.
     * Converts services string to an array if provided.
     *
     * @param \App\Models\Doctor $doctor
     * @param array $data
     * @return \App\Models\Doctor
     */
    public function update(Doctor $doctor, array $data)
    {
        if (isset($data['services'])) {
            $data['services'] = array_filter(array_map('trim', explode('،', $data['services'])));
        }
        $doctor->update($data);
        return $doctor;
    }

    /**
     * Delete a doctor record.
     *
     * @param \App\Models\Doctor $doctor
     * @return bool|null
     */
    public function delete(Doctor $doctor)
    {
        return $doctor->delete();
    }
}
