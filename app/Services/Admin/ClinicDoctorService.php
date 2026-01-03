<?php

namespace App\Services\Admin;

use App\Models\Clinic;

class ClinicService
{
    public function get()
    {
        // نجيب أول سجل موجود
        return Clinic::first();
    }

    public function update(Clinic $clinic, array $data)
    {
        $clinic->update($data);
        return $clinic;
    }
}
