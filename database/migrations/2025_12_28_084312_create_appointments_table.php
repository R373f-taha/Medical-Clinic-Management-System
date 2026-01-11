<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->nullable()->constrained('patients')->nullOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('medical_record_id')->nullable()->constrained('medical_records')->nullOnDelete();

            $table->dateTime('appointment_date');

            $table->enum('status', [
                'hold',
                'scheduled',
                'completed',
                'cancelled'
            ])->default('hold');

            $table->timestamp('hold_expires_at')->nullable();
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['doctor_id', 'appointment_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
