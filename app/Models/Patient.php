<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservation(){
        return $this->hasOne(Reservation::class);
    }
    public function medicalRecord(){
        return $this->hasOne(MedicalRecord::class);
    }
    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
    public function rating(){
        return $this->hasMany(Rating::class);
    }
}
