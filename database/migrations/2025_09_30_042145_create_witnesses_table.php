<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('witnesses', function (Blueprint $table) {
            $table->id();

            // Link to hearing (not just case)
            $table->foreignId('hearing_id')->constrained('case_hearings')->cascadeOnDelete();

            $table->string('name');
            $table->string('phone');

            // Attendance / status for this hearing
            $table->enum('appeared_status', ['pending', 'appeared', 'absent', 'excused'])->default('pending');
            $table->enum('gender', ['Female', 'Male', 'Third Gender'])->nullable();
            $table->enum('others_info', ['Under 18', 'Person with Disability'])->nullable();
            $table->enum('sms_seen', ['yes', 'no'])->nullable();
            $table->enum('witness_heard', ['yes', 'no'])->nullable();

            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('witnesses');
    }
};
