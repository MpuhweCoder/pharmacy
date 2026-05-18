<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();

            // Foreign key to categories
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('restrict'); // prevent deleting category with medicines

            // Basic info
            $table->string('name', 200);
            $table->string('slug', 200)->unique();
            $table->string('brand', 100)->nullable();       // manufacturer brand
            $table->string('generic_name', 200)->nullable(); // scientific name
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);                // selling price
            $table->decimal('cost_price', 10, 2)->nullable();// purchase cost
            $table->decimal('discount', 5, 2)->default(0);  // discount percentage

            // Stock
            $table->integer('stock')->default(0);
            $table->integer('min_stock_alert')->default(10); // alert when stock < this

            // Medicine details
            $table->string('dosage', 100)->nullable();       // e.g. 500mg
            $table->string('form', 50)->nullable();          // tablet, syrup, capsule
            $table->date('expiry_date')->nullable();

            // Image
            $table->string('image')->nullable();             // stored path

            // Flags
            $table->boolean('requires_prescription')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes(); // soft delete — medicine won't be hard deleted
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};