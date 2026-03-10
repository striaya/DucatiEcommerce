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
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->string('provider', 80)->comment('Nama leasing: ACC, WOM, BAF, dll');
            $table->integer('tenure_months')->comment('Tenor: 12, 24, 36, 48, 60 bulan');
            $table->decimal('interest_rate_pct', 5, 2)->comment('Bunga flat per tahun (%)');
            $table->decimal('dp_amount', 14, 2);
            $table->decimal('loan_amount', 14, 2);
            $table->decimal('monthly_installment', 12, 2);
            $table->decimal('total_payment', 14, 2);
            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'active',
                'completed',
            ])->default('pending');
            $table->text('doc_ktp_url')->nullable();
            $table->text('doc_slip_gaji_url')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
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
