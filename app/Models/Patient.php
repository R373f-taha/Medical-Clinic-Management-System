<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',      
        'blood_type',
        'height',
        'weight',
        'gender',
        'allergies',
    ];
    protected $table = 'patients';
    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function medicalRecord(){
        return $this->hasOne(MedicalRecord::class);
    }
    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
    public function rating(){
        return $this->hasMany(Rating::class);
    }
}
