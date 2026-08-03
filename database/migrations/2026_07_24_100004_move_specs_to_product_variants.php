<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add specs JSON column to product_variants
        Schema::table('product_variants', function (Blueprint $table) {
            $table->json('specs')->nullable()->after('stock_qty');
        });

        // 2. Migrate existing data from product_details.specs (JSON)
        $details = DB::table('product_details')->whereNotNull('specs')->get();
        foreach ($details as $detail) {
            $specs = json_decode($detail->specs, true);
            if (!empty($specs)) {
                DB::table('product_variants')->where('product_id', $detail->product_id)->update([
                    'specs' => json_encode($specs, JSON_UNESCAPED_UNICODE)
                ]);
            }
        }

        // 3. Drop 'specs' column from product_details
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn('specs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->json('specs')->nullable();
        });

        // Migrate back if possible
        $variants = DB::table('product_variants')->whereNotNull('specs')->get();
        foreach ($variants as $variant) {
            DB::table('product_details')
                ->where('product_id', $variant->product_id)
                ->update(['specs' => $variant->specs]);
        }

        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('specs');
        });
    }
};
