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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('order_id');
            $table->enum('method', [
                'va_bank',
                'credit_card',
                'e_wallet',
                'qris',
                'installment'
            ]);
            $table->string('gateway', 60)->comment('Midtrans / Xendit / Doku');
            $table->string('transaction_ref', 150)->nullable()->unique()->comment('Ref dari payment gateway');
            $table->decimal('amount', 14, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            $table->string('va_number', 50)->nullable()->comment('Diisi jika metode VA Bank');
            $table->text('qr_code_url')->nullable()->comment('Diisi jika metode QRIS');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
