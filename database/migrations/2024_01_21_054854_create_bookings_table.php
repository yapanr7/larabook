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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('package_id')->references('id')->on('packages')->cascadeOnDelete();
            $table->string('code')->unique();
            $table->date('date');
            $table->time('time');
            $table->text('note')->nullable();
            $table->enum('status', ['pending', 'booked', 'canceled', 'completed'])->default('pending');
            $table->text('download')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
