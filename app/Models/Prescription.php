<?php

namespace App\Models;

use  App\Models\MedicalRecord;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;
    protected $table = 'prescriptions';
    protected $guarded=[];
    protected $fillable = [
        'medical_record_id',
        'medicine_name',
        'dosage',
        'frequency',
        'refills',
        'instructions',
        'duration',
    ];
    public function medical_record(){
        return $this->belongsTo(MedicalRecord::class);
    }
}
