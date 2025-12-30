<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
   use HasFactory;
   protected $table = 'reservation';
   protected $guarded=[];
   public function employee(){
    return $this->belongsTo(Employee::class);
   }
   public function patient(){
    return $this->belongsTo(Patient::class);
   }

}
