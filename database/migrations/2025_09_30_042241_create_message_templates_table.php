<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., CourtSMS, English, Bangla etc.

            // Separate bodies for each channel and language
            $table->text('body_en_sms')->nullable();
            $table->text('body_en_whatsapp')->nullable();
            $table->text('body_bn_sms')->nullable();
            $table->text('body_bn_whatsapp')->nullable();
            $table->text('body_email')->nullable(); // Email content (English)

            $table->enum('channel', ['sms', 'whatsapp', 'both', 'email'])->default('sms');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
