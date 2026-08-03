<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ตารางเก็บเรทราคาสำหรับระบบ Custom ทุกประเภท
     * ออกแบบให้ยืดหยุ่น รองรับการเพิ่มเรทในอนาคต
     */
    public function up(): void
    {
        Schema::create('custom_pricing_rates', function (Blueprint $table) {
            $table->id();
            $table->string('scope', 50)->index();       // rope, rope_color, screen_color, screen_block, part, yoyo, express, sample
            $table->string('scope_key', 100)->index();   // e.g. "1_10mm_1side", "extra_standard", "96" (part_id)
            $table->string('label')->nullable();          // ชื่อแสดงผล
            $table->integer('min_qty')->default(1);       // จำนวนขั้นต่ำของเรทนี้
            $table->decimal('price', 10, 2);              // ราคาต่อหน่วย ณ เรทนี้
            $table->string('fee_type', 20)->default('per_unit'); // per_unit, flat, percent
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Composite index for fast lookups
            $table->index(['scope', 'scope_key', 'min_qty']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_pricing_rates');
    }
};
