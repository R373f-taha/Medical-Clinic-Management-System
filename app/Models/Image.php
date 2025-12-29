<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Image extends Model
{
  use HasFactory;
  protected $table = 'images';
  protected $guarded=[];
  public function medical_record(){
    return $this->belongsTo(MedicalRecord::class);
  }
}
