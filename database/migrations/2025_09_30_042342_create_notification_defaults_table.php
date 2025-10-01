<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_defaults', function (Blueprint $table) {
            $table->id();
            $table->integer('days_before'); // e.g. 10, 3, 0
            $table->foreignId('template_id')->constrained('message_templates')->cascadeOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_defaults');
    }
};
