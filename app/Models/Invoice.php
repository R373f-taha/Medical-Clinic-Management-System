<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
  use HasFactory;
  protected $table = 'invoices';
  protected $guarded=[];
  public function appointment(){
    return $this->belongsTo(Appointment::class);
  }
  public function patient() {
    return $this->belongsTo(Patient::class);
}
}
