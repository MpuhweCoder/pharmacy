<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add role column: admin, pharmacist, customer
            $table->enum('role', ['admin', 'pharmacist', 'customer'])
                  ->default('customer')
                  ->after('email');

            // Add phone number
            $table->string('phone', 15)->nullable()->after('role');

            // Add address
            $table->text('address')->nullable()->after('phone');

            // Is account active?
            $table->boolean('is_active')->default(true)->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'address', 'is_active']);
        });
    }
};