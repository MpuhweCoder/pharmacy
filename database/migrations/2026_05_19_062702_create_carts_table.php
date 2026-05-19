<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // Logged-in user (nullable for guest cart via session)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');

            // Session ID for guest users who haven't logged in yet
            $table->string('session_id')->nullable();

            // Cart status
            $table->enum('status', ['active', 'converted', 'abandoned'])
                  ->default('active');

            $table->timestamps();

            // A user should have only one active cart at a time
            $table->index(['user_id', 'status']);
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};