<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('witnesses', function (Blueprint $table) {
            // Modify the 'others_info' enum to include 'Both'
            $table->enum('others_info', ['Under 18', 'Person with Disability', 'Both'])
                  ->nullable()
                  ->change();

            // Add new column 'type_of_witness'
            $table->enum('type_of_witness', ['IO', 'MO', 'DNC', 'General', 'Others'])
                  ->after('others_info')
                  ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('witnesses', function (Blueprint $table) {
            // Revert 'others_info' back to original
            $table->enum('others_info', ['Under 18', 'Person with Disability'])
                  ->nullable()
                  ->change();

            // Drop the 'type_of_witness' column
            $table->dropColumn('type_of_witness');
        });
    }
}; 
