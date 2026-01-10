<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'medical_record_id',
        'notes',
        'appointment_date',
        'status',
        'reason',
        'hold_expires_at',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'hold_expires_at'  => 'datetime',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }


    public function isOnHold(): bool
    {
        return $this->status === 'hold'&& $this->hold_expires_at&& Carbon::now()->lt($this->hold_expires_at);
    }
}
