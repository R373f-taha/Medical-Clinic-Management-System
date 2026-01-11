<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
    $table->id();

    $table->foreignId('patient_id')->nullable()->constrained('patients') ->nullOnDelete();

    $table->foreignId('doctor_id') ->constrained('doctors')->cascadeOnDelete();

    // السجل الطبي (يُنشأ لاحقاً من الطبيب)
    //$table->foreignId('medical_record_id')->nullable() ->constrained('medical_records')->nullOnDelete();

    $table->dateTime('appointment_date');

    // حالة الموعد
    $table->enum('status', [
        'hold',        // حجز من المريض (بانتظار الموظف)
        'scheduled',   // مقبول / مضاف من طبيب
        'completed',   // مكتمل
        'cancelled'    // مرفوض / ملغي
    ])->default('hold');

    // انتهاء الحجز المؤقت
    $table->timestamp('hold_expires_at')->nullable();

    $table->text('reason')->nullable();

    $table->text('notes')->nullable();

    $table->timestamps();

    // منع تداخل المواعيد (كل 30 دقيقة لنفس الطبيب)
    $table->unique(['doctor_id', 'appointment_date']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
