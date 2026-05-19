<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            $table->foreignId('medicine_id')
                  ->constrained('medicines')
                  ->onDelete('restrict');

            // Snapshot of medicine details at time of order
            // (so invoice stays correct even if medicine price changes)
            $table->string('medicine_name', 200);
            $table->string('medicine_brand', 100)->nullable();

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);   // price after discount
            $table->decimal('original_price', 10, 2); // original price
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};