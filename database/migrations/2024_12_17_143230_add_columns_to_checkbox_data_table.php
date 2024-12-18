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
        Schema::table('checkbox_data', function (Blueprint $table) {
            $table->timestamp('arrival_recorded_at')->nullable();
            $table->timestamp('departure_recorded_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkbox_data', function (Blueprint $table) {
            //
        });
    }
};
