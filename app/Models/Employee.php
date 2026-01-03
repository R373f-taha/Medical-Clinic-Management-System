<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
     use HasFactory;
   protected $table = 'employees';
    protected $fillable = ['user_id','name','qualifications','age','phone', 'email',
'gender','date_of_birth'];

  public function user(){
    return $this->belongsTo(User::class);
  }
  public function reservation(){
    return $this->hasMany(Reservation::class);
  }
}
