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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id('address_id');
            $table->unsignedBigInteger('user_id');
            $table->string('label', 50)->default('Rumah');
            $table->string('recipient_name', 100);
            $table->text('street');
            $table->string('city', 80);
            $table->string('province', 80);
            $table->string('postal_code', 10);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->foreign('user_id')
            ->references('user_id')
            ->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
