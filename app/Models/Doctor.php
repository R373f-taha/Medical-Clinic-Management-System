<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
   use HasFactory;
   protected $table = 'doctors';
   protected $guarded=[];
   protected $fillable = [
      'user_id',
      'specialization',
      'qualifications',
      'available_hours',
      'experience_years',
      'current_rate',
  ];
  public function user()
  {
      return $this->belongsTo(User::class, 'user_id');
  }
 public function medical_records()
 {
     return $this->hasMany(MedicalRecord::class, 'doctor_id');
 }
 public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
 public function rating(){
    return $this->hasOne(Rating::class);
 }
 public function clinic(){
    return $this->belongsTo(Clinic::class);
 }
}
