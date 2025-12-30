<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patient';
    protected $guarded=[];
   public function user(){
    return $this->belongsTo(User::class);
   }
   public function reservation(){
    return $this->hasOne(Reservation::class);
   }
   public function medical_records(){
    return $this->hasMany(MedicalRecord::class);
   }
   public function appointments(){
     return $this->hasMany(Appointment::class);
   }
   public function rating(){
    return $this->hasOne(Rating::class);
   }
}
