<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
     use HasFactory,HasRoles;
   protected $table = 'employees';
    protected $fillable = ['user_id','name','qualifications','age','phone', 'email',
'gender','date_of_birth'];

  public function user(){
    return $this->belongsTo(User::class);
  }
}
