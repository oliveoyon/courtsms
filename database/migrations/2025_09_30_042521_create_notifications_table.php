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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->nullable()->constrained('notification_schedules')->cascadeOnDelete();
            $table->foreignId('witness_id')->constrained('witnesses')->cascadeOnDelete();
            $table->enum('channel', ['sms', 'whatsapp', 'both'])->default('sms');
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed', 'cancelled'])->default('pending');
            $table->dateTime('sent_at')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
