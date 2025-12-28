<?php

namespace App\Models;

use Faker\Provider\Medical;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{   protected $guarded=[];
    public function medical_record(){
        return $this->belongsTo(Medical::class);
    }
}
