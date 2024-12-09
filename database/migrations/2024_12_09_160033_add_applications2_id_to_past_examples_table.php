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
        Schema::table('past_examples', function (Blueprint $table) {
            $table->unsignedBigInteger('applications2_id')->nullable();
            $table->foreign('applications2_id')->references('id')->on('applications2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('past_examples', function (Blueprint $table) {
            //
        });
    }
};
