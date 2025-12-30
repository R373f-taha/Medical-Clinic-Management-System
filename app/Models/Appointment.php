<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{ protected $guarded=[];
    public function medical_record()   {
        return $this->belongsTo(Appointment::class);
    }
    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
}
