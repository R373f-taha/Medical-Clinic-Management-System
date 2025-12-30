<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Clinic extends Model
{
    use HasFactory;
    protected $table = 'clinic';
    protected $guarded=[];
    public function doctors(){
    return $this->hasMany(Doctor::class);
 }
}
