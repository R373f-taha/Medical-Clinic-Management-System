<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
   use HasFactory;
   protected $fillable = [
      'patient_id',       
      'doctor_id',         
      'medical_record_id', 
      'notes',
      'appointment_date',
      'status',            
      'reason',
  ];
   protected $table = 'appointments';
   protected $guarded=[];
   public function medicalRecord()   {
    return $this->belongsTo(MedicalRecord::class);
   }
   public function invoice(){
    return $this->hasOne(Invoice::class);
   }
   public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
   public function doctor()
   {
       return $this->belongsTo(Doctor::class, 'doctor_id');
   }

}
