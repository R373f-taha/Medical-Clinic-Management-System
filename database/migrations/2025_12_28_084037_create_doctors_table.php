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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->unique();
            //Many to Many with clinic...
            $table->string('specialization');
            $table->string('qualifications');
            $table->integer('available_hours');
            $table->integer('experience_years')->nullable();
            $table->decimal('current_rate', 2, 1)->default(0);
            /*
                I added this field to store the doctor's most recent rating
                after it has been calculated according to the rating algorithm...
            */
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
