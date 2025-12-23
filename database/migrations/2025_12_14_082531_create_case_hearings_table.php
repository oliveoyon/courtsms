<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create case_hearings table
        Schema::create('case_hearings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('cases')->cascadeOnDelete();
            $table->date('hearing_date');
            $table->time('hearing_time')->nullable();
            $table->boolean('is_reschedule')->default(false);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // Update witnesses table to link to hearing instead of case
        Schema::table('witnesses', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
            $table->dropColumn('case_id');
            $table->foreignId('hearing_id')->after('id')->constrained('case_hearings')->cascadeOnDelete();
        });

        // Update notification_schedules table to link to hearing instead of case
        Schema::table('notification_schedules', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
            $table->dropColumn('case_id');
            $table->foreignId('hearing_id')->after('id')->constrained('case_hearings')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Rollback changes
        Schema::table('notification_schedules', function (Blueprint $table) {
            $table->dropForeign(['hearing_id']);
            $table->dropColumn('hearing_id');
            $table->foreignId('case_id')->after('id')->constrained('cases')->cascadeOnDelete();
        });

        Schema::table('witnesses', function (Blueprint $table) {
            $table->dropForeign(['hearing_id']);
            $table->dropColumn('hearing_id');
            $table->foreignId('case_id')->after('id')->constrained('cases')->cascadeOnDelete();
        });

        Schema::dropIfExists('case_hearings');
    }
};
