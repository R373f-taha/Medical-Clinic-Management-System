<?php

namespace App\Services\Admin;

use App\Models\Clinic;

class ClinicService
{
    public function getAll()
    {
        return Clinic::latest()->get();
    }

    public function store(array $data): Clinic
    {
        return Clinic::create($data);
    }

    public function update(Clinic $clinic, array $data): Clinic
    {
        $clinic->update($data);
        return $clinic;
    }

    public function delete(Clinic $clinic): bool
    {
        return $clinic->delete();
    }
}
