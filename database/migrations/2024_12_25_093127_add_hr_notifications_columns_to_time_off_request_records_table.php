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
        Schema::table('time_off_request_records', function (Blueprint $table) {
            $table->boolean('hr_checked')->default(false);
            $table->unsignedBigInteger('hr_checked_by')->nullable();
            $table->timestamp('hr_checked_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_off_request_records', function (Blueprint $table) {
            //
        });
    }
};
