<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
   use HasFactory;
   protected $table = 'doctor';
   protected $guarded=[];
 public function user(){
    return $this->belongsTo(User::class);
 }
 public function medicaa_records(){
    return $this->hasMany(Doctor::class);
 }
 public function appointments(){
   return $this->hasMany(Appointment::class);
 }
 public function rating(){
    return $this->hasOne(Rating::class);
 }
 public function clinic(){
    return $this->belongsTo(Clinic::class);
 }
}
