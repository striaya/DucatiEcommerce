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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('category_id');
            $table->string('name', 200);
            $table->string('slug', 220)->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 14, 2);
            $table->integer('stock')->default(0);
            $table->text('image_url')->nullable();
            $table->integer('engine_cc')->nullable()->comment('Kapasitas mesin (cc)');
            $table->decimal('power_hp', 6, 1)->nullable()->comment('Tenaga mesin (HP)');
            $table->boolean('credit_eligible')->default(false)->comment('Bisa dibeli kredit');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('categories')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
