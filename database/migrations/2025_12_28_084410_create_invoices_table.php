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
     Schema::create('invoices', function (Blueprint $table) {
    $table->id();

    $table->foreignId('patient_id')
        ->constrained('patients')
        ->cascadeOnDelete();

    $table->foreignId('appointment_id')
        ->constrained('appointments')
        ->cascadeOnDelete()
        ->unique();

    $table->integer('subtotal');     
    $table->integer('tax')->default(0);
    $table->integer('discount')->default(0);

    $table->integer('total_amount');

    $table->enum('status', ['paid', 'unpaid']);
    $table->date('invoice_date');

    $table->enum('payment_method', [
        'cash', 'card', 'online', 'bank_transfer'
    ])->default('cash');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
