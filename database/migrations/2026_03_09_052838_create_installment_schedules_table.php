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
        Schema::create('installment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_id')
                  ->constrained('credit_applications')
                  ->onDelete('cascade');
            $table->integer('period_number')->comment('Cicilan ke-N');
            $table->date('due_date');
            $table->decimal('amount_due', 12, 2);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->enum('status', ['upcoming', 'paid', 'late', 'waived'])->default('upcoming');
            $table->decimal('late_penalty', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_schedules');
    }
};
