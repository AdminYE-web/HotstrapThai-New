<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Migrate existing data from products table into new tables.
     */
    public function up(): void
    {
        // Get all products with their current data
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            // 1. Create product_details row
            DB::table('product_details')->insert([
                'product_id'    => $product->id,
                'type'          => $product->type ?? 'custom',
                'occasion_type' => $product->occasion_type,
                'description'   => $product->description,
                'created_at'    => $product->created_at,
                'updated_at'    => $product->updated_at,
            ]);

            // 2. Create a default product_variants row
            DB::table('product_variants')->insert([
                'product_id'       => $product->id,
                'sku'              => $product->slug,
                'product_size'     => $product->product_size ?? null,
                'product_color'    => $product->product_color ?? null,
                'product_material' => $product->product_material ?? null,
                'price'            => $product->base_price,
                'stock_qty'        => $product->stock_qty ?? 0,
                'created_at'       => $product->created_at,
                'updated_at'       => $product->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data migration reversal: copy data back to products table
        $details = DB::table('product_details')->get();
        foreach ($details as $detail) {
            DB::table('products')->where('id', $detail->product_id)->update([
                'type'          => $detail->type,
                'occasion_type' => $detail->occasion_type,
                'description'   => $detail->description,
            ]);
        }

        // Truncate the new tables
        DB::table('product_details')->truncate();
        DB::table('product_variants')->truncate();
    }
};
