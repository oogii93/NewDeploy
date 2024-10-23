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
        Schema::create('name_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('company');
            $table->string('phone');
            $table->string('email');
            $table->string('image'); // To store the image path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('name_cards');
    }
};
