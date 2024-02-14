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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('Photostudio Booking');
            $table->string('app_tagline')->default('Booking Photo Jadi Lebih Mudah');
            $table->string('app_logo')->nullable();
            $table->string('app_favicon')->nullable();
            $table->string('app_background')->nullable();
            $table->boolean('enable_qris_payment')->default(true);
            $table->string('tripay_merchant_code');
            $table->string('tripay_api_key');
            $table->string('tripay_private_key');
            $table->string('tripay_transaction_url')->default('https://tripay.co.id/api-sandbox/transaction/create');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
