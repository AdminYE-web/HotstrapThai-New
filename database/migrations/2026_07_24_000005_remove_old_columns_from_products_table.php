<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove old columns from products table (data already migrated).
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'stock_qty',
                'occasion_type',
                'description',
                'product_size',
                'product_color',
                'product_material',
            ]);
        });
    }

    /**
     * Restore old columns to products table.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->default('custom')->after('base_price');
            $table->integer('stock_qty')->default(0)->after('type');
            $table->string('occasion_type')->nullable()->after('stock_qty');
            $table->text('description')->nullable()->after('is_active');
            $table->string('product_size')->nullable()->after('description');
            $table->string('product_color')->nullable()->after('product_size');
            $table->string('product_material')->nullable()->after('product_color');
        });
    }
};
