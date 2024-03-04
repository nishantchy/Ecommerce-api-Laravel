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
        Schema::create('_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('list_price');
            $table->float('sale_price');
            $table->string('stocks');
            $table->string('image');
            $table->string('details');
            $table->string('category');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_products');
    }
};
