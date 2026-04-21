<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sale_id')
                ->constrained('sales')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate();

            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->decimal('subtotal', 12, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
