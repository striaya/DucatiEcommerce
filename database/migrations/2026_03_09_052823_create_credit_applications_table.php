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
        Schema::create('credit_applications', function (Blueprint $table) {
            $table->id('credit_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id');
            $table->string('provider', 80)->comment('Nama leasing: ACC, WOM, BAF, dll');
            $table->integer('tenure_months')->comment('Tenor: 12, 24, 36, 48, 60 bulan');
            $table->decimal('interest_rate_pct', 5, 2)->comment('Bunga flat per tahun (%)');
            $table->decimal('dp_amount', 14, 2)->comment('Uang muka');
            $table->decimal('loan_amount', 14, 2)->comment('Pokok hutang');
            $table->decimal('monthly_installment', 12, 2)->comment('Cicilan per bulan');
            $table->decimal('total_payment', 14, 2)->comment('Total bayar termasuk bunga');
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'active',
                'completed'
            ])->default('pending');
            $table->text('doc_ktp_url')->nullable();
            $table->text('doc_slip_gaji_url')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                  ->references('order_id')
                  ->on('orders')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_applications');
    }
};
