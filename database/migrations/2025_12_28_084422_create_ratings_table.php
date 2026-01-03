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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();//->unique();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();//->unique();
            $table->tinyInteger('rating'); 
            $table->date('date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['patient_id','doctor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
