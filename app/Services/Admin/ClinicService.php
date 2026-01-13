<?php

namespace App\Services\Admin;

use App\Models\Clinic;

class ClinicService
{
    public function get()
    {
        return Clinic::first();
    }

    public function update(Clinic $clinic, array $data)
    {
        $clinic->update($data);
        return $clinic;
    }
}
