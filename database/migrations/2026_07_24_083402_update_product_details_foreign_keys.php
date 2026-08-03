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
        // 1. Insert seed data so we have IDs to map to
        $typeMap = [
            'custom' => 'สั่งทำพิเศษ',
            'ready_to_ship' => 'สินค้าพร้อมส่ง',
            'contact' => 'ติดต่อสั่งซื้อ',
            'parts' => 'อะไหล่/อุปกรณ์เสริม',
        ];
        foreach ($typeMap as $slug => $name) {
            DB::table('product_types')->insertOrIgnore(['name' => $name, 'slug' => $slug]);
        }

        $occasionMap = [
            'office' => 'สำนักงาน',
            'event' => 'อีเวนต์/งานจัดแสดง',
            'school' => 'สถานศึกษา',
        ];
        foreach ($occasionMap as $slug => $name) {
            DB::table('occasion_types')->insertOrIgnore(['name' => $name, 'slug' => $slug]);
        }

        // 2. Add foreign key columns to product_details
        Schema::table('product_details', function (Blueprint $table) {
            $table->foreignId('product_type_id')->nullable()->after('product_id')->constrained('product_types');
            $table->foreignId('occasion_type_id')->nullable()->after('product_type_id')->constrained('occasion_types');
        });

        // 3. Migrate data
        $details = DB::table('product_details')->get();
        foreach ($details as $detail) {
            $typeId = DB::table('product_types')->where('slug', $detail->type)->value('id');
            $occasionId = DB::table('occasion_types')->where('slug', $detail->occasion_type)->value('id');

            DB::table('product_details')
                ->where('id', $detail->id)
                ->update([
                    'product_type_id' => $typeId,
                    'occasion_type_id' => $occasionId,
                ]);
        }

        // 4. Drop old columns
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn(['type', 'occasion_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('occasion_type')->nullable();
        });

        $details = DB::table('product_details')->get();
        foreach ($details as $detail) {
            $typeSlug = DB::table('product_types')->where('id', $detail->product_type_id)->value('slug');
            $occasionSlug = DB::table('occasion_types')->where('id', $detail->occasion_type_id)->value('slug');

            DB::table('product_details')
                ->where('id', $detail->id)
                ->update([
                    'type' => $typeSlug,
                    'occasion_type' => $occasionSlug,
                ]);
        }

        Schema::table('product_details', function (Blueprint $table) {
            $table->dropForeign(['product_type_id']);
            $table->dropForeign(['occasion_type_id']);
            $table->dropColumn(['product_type_id', 'occasion_type_id']);
        });
    }
};
