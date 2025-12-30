<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
   use HasFactory;
   protected $table = 'ratings';
   public function patient(){
    return $this->belongsTo(Patient ::class);
   }
   public function doctor(){
    return $this->belongsTo(Doctor::class);
   }
}
