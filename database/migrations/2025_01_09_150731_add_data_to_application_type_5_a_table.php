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
        Schema::table('application_type_5_a', function (Blueprint $table) {
            $table->enum('tsr_status',['yes', 'no'])->nullable();
            $table->enum('prm_status',['yes', 'no'])->nullable();
            $table->string('score')->nullable();
            $table->string('recent_sales')->nullable();
            $table->string('profit')->nullable();
            $table->string('own_value')->nullable();
            $table->enum('entity_type', ['individual', 'corporate'])->nullable();

            $table->enum('guarantor_type',['1','2'])->nullable();
            $table->enum('home_ownership',['1','2'])->nullable();
            $table->enum('company_ownership',['1','2'])->nullable();
            $table->string('result_input')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('application_type_5_a', function (Blueprint $table) {
            //
        });
    }
};
