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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('product_name');
            $table->string('image_url')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->json('options_snapshot')->nullable(); // e.g. ["10mm", "สกรีนด้านเดียว", "คลิปดำ", "สีFlag red,361C", "200เส้น", "ตัวอย่าง", "แบบเร่งด่วน"]
            $table->boolean('is_preorder')->default(false);
            $table->string('lead_time')->nullable(); // e.g. "1-3 วันทำการ" or "14-21 วันทำการ"
            $table->boolean('is_selected')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
