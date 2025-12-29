<?php

namespace App\Models;

use Faker\Provider\Medical;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{ 
    use HasFactory;
    protected $table = 'prescription';  
    protected $guarded=[];
    public function medical_record(){
        return $this->belongsTo(Medical::class);
    }
}
