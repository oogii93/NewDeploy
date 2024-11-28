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
        Schema::create('computer_form_type_01_z', function (Blueprint $table) {
            $table->id();
            $table->string('corp')->nullable();
            $table->string('office')->nullable();

            $table->string('name')->nullable();
            $table->dateTime('occured_date')->nullable();

            $table->text('description')->nullable();
            $table->enum('answer',['優先度','緊急度'])->nullable(); // For storing radio button selection (option1 or option2)
            $table->string('screen_copy')->nullable();
            $table->text('self_attempt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('computer_form_type_01_z');
    }
};
