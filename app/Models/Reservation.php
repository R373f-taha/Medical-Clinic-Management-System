<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded=[];
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }

}
