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
        Schema::create('witness_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hearing_id')->constrained('case_hearings')->cascadeOnDelete();
            $table->foreignId('witness_id')->constrained('witnesses')->cascadeOnDelete();
            $table->enum('status', ['pending', 'appeared', 'absent', 'excused'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('witness_attendances');
    }
};
