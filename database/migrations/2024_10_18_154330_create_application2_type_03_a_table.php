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
        Schema::create('application2_type_03_a', function (Blueprint $table) {
            $table->id();
            $table->string('corp')->nullable();
            $table->string('office')->nullable();
            $table->string('division')->nullable();
            $table->string('name')->nullable();
            $table->string('companyProfile')->nullable();
            $table->string('cover')->nullable(); // For storing radio button selection (option1 or option2)
            $table->string('order')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application2_type_03_a');
    }
};
