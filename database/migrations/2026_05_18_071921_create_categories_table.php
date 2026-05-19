<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Category name e.g. Antibiotics, Vitamins
            $table->string('name', 100)->unique();

            // URL-friendly slug e.g. antibiotics
            $table->string('slug', 100)->unique();

            // Short description
            $table->text('description')->nullable();

            // Category icon (Bootstrap icon name)
            $table->string('icon', 50)->default('bi-capsule');

            // Show/hide category
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};