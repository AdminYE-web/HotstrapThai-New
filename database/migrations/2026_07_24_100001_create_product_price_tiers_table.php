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
        Schema::create('product_price_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('min_qty'); // จำนวนขั้นต่ำ เช่น 1, 100, 1000
            $table->decimal('price', 10, 2); // ราคาที่ tier นี้
            $table->timestamps();

            // Index เพื่อ query เร็ว
            $table->index(['product_id', 'min_qty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price_tiers');
    }
};
