<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
   use HasFactory;
   protected $table = 'doctors';
   protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

 public function medicaa_records(){
    return $this->hasMany(MedicalRecord::class);
 }

 public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
 public function rating(){
    return $this->hasMany(Rating::class);
 }
 public function clinic(){
    return $this->belongsTo(Clinic::class);
 }
}
