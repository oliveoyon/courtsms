<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();
            $table->foreignId('template_id')->constrained('message_templates')->cascadeOnDelete();
            $table->enum('channel', ['sms','whatsapp','both'])->default('sms');
            $table->enum('status', ['active','inactive'])->default('active');
            $table->dateTime('schedule_date')->nullable();
            $table->time('schedule_time')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_schedules');
    }
};
