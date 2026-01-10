<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Prescription;

class MedicalRecord extends Model
{
   
   use HasFactory;
   protected $table = 'medical_records';
   protected $guarded=[];
    protected $dates = ['follow_up_date'];


   public function doctor(){
    return $this->belongsTo(Doctor::class);
   }
   public function patient(){
    return $this->belongsTo(Patient::class);
   }
   public function images(){
    return $this->hasMany(Image::class);
   }
   public function appointment(){
    return $this->hasOne(Appointment::class);
   }
   public function prescriptions()
   {
       return $this->hasMany(Prescription::class);
   }


}

