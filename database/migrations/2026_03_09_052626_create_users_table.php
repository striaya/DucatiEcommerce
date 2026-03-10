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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('email', 150)->unique();
            $table->string('password_hash', 255);
            $table->string('phone', 20)->nullable();
            $table->string('nik', 16)->unique()->nullable();
            $table->enum('role', ['customer', 'admin'])->default('customer');
            $table->enum('kyc_status', ['unverified', 'verified', 'rejected'])->default('unverified');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
