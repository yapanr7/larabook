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

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'bank', 'qris'])->nullable();
            $table->enum('status', ['unpaid', 'paid', 'failed', 'expired'])->default('unpaid');

            // Tripay
            $table->string('callback_url')->nullable();
            $table->string('checkout_url')->nullable();
            $table->string('return_url')->nullable();
            $table->string('pay_code')->nullable();
            $table->string('pay_url')->nullable();
            $table->string('qr_string')->nullable();
            $table->string('qr_url')->nullable();
            $table->string('expired_time')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
