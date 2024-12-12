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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('office_name')->nullable();
            $table->string('maker_name')->nullable();
            $table->string('product_number')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('pieces')->nullable();
            $table->integer('icm_net')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('purchased_from')->nullable();
            $table->integer('list_price',)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
