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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id');
            $table->string('order_number', 30)->unique();
            $table->enum('purchase_type', ['cash', 'credit'])->default('cash');
            $table->enum('status', [
                'pending',
                'confirmed',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending');
            $table->decimal('subtotal', 14, 2);
            $table->decimal('grand_total', 14, 2);
            $table->timestamp('ordered_at')->useCurrent();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('address_id')
                  ->references('address_id')
                  ->on('user_addresses')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
