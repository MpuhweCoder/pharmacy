<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Customer who placed the order
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            // Unique order number e.g. MED-2024-00001
            $table->string('order_number', 30)->unique();

            // Order status flow:
            // pending → confirmed → processing → shipped → delivered
            // or: pending → cancelled
            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
            ])->default('pending');

            // Payment
            $table->enum('payment_method', [
                'cod',           // cash on delivery
                'razorpay',
                'upi',
            ])->default('cod');

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded',
            ])->default('pending');

            // Pricing breakdown
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);

            // Delivery address (snapshot at time of order)
            $table->string('delivery_name', 100);
            $table->string('delivery_phone', 15);
            $table->text('delivery_address');
            $table->string('delivery_city', 100);
            $table->string('delivery_state', 100);
            $table->string('delivery_pincode', 10);

            // Optional notes from customer
            $table->text('notes')->nullable();

            // Timestamps for status changes
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index for faster queries
            $table->index(['user_id', 'status']);
            $table->index('order_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};