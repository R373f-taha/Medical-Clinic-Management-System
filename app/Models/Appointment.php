<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
   use HasFactory;
   protected $table = 'appointments';
   protected $guarded=[];

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
