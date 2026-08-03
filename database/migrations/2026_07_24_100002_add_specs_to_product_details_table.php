<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * เพิ่มคอลัมน์ specs (JSON) สำหรับเก็บรายละเอียดสเปกสินค้าแต่ละประเภท
     * เช่น ซอง PVC: {"รูปแบบ": "ซองใส่บัตรแนวนอน", "ขนาดซอง": "87mm x 100mm", ...}
     * เช่น สายคล้อง: {"ขนาด": "10mm", "สี": "Flag red", "วัสดุ": "ผ้าโพลีเอสเตอร์"}
     */
    public function up(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->json('specs')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn('specs');
        });
    }
};
