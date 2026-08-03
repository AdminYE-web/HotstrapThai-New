<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 1. เปลี่ยนชื่อ product_price_tiers → product_prices
     * 2. ลบคอลัมน์ price ออกจาก product_variants (ย้ายมาอยู่ product_prices ทั้งหมด)
     */
    public function up(): void
    {
        Schema::rename('product_price_tiers', 'product_prices');

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->default(0)->after('sku');
        });

        Schema::rename('product_prices', 'product_price_tiers');
    }
};
