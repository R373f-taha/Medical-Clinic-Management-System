<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::saving(function ($invoice) {
            $subtotal = (float) ($invoice->subtotal ?? 0);
            $tax      = (float) ($invoice->tax ?? 0);
            $discount = (float) ($invoice->discount ?? 0);

            $taxAmount = ($subtotal * $tax) / 100;

            $invoice->total_amount = max(
                ($subtotal + $taxAmount) - $discount,
                0
            );
        });
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
