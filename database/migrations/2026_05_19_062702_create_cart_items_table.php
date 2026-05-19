<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();

            // Which cart this item belongs to
            $table->foreignId('cart_id')
                  ->constrained('carts')
                  ->onDelete('cascade');

            // Which medicine was added
            $table->foreignId('medicine_id')
                  ->constrained('medicines')
                  ->onDelete('cascade');

            // Quantity added by user
            $table->integer('quantity')->default(1);

            // Store price at the time of adding to cart
            // (in case medicine price changes later)
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 5, 2)->default(0);

            $table->timestamps();

            // Prevent duplicate medicine in same cart
            $table->unique(['cart_id', 'medicine_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};