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
            $table->unsignedBigInteger('past_examples_category_id')->nullable();

            $table->foreign('past_examples_category_id')
            ->references('id')
            ->on('past_examples_category')
            ->onDelete('set null');


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
