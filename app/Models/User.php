<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;
  protected $guard_name = 'api';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
        public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function getJWTIdentifier()
    {
         return $this->getKey();
    }
    public function getJWTCustomClaims(){
       return [

            'email' => $this->email,
            'name' => $this->name,];

    }




}
