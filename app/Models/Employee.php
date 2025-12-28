<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{ protected $guarded=[];
    protected $fillable = ['user_id','name','qualificatins','age','phone', 'email',
'gender','date_of_birth'];

  public function user(){
    return $this->belongsTo(User::class);
  }
  public function reservation(){
    return $this->hasMany(Reservation::class);
  }
}
