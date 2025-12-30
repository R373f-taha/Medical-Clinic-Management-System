<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded=[];
    public function medical_record(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
