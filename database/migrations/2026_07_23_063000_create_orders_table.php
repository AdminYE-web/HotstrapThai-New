<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();                       // e.g. ORD-20260723-0001
            $table->foreignId('quotation_id')->nullable()->constrained('quotations')->onDelete('set null');

            // ข้อมูลลูกค้า / ที่อยู่จัดส่ง
            $table->string('customer_name');
            $table->string('company_name')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->text('address');                                     // ที่อยู่จัดส่ง (formatted)

            // ใบกำกับภาษี
            $table->string('tax_invoice_type')->default('none');         // none, paper
            $table->string('tax_person_type')->nullable();              // individual, corporate
            $table->string('tax_id')->nullable();                       // เลขผู้เสียภาษี
            $table->string('tax_name')->nullable();                     // ชื่อในใบกำกับ
            $table->string('tax_phone')->nullable();
            $table->string('tax_branch')->nullable();                   // สำนักงาน/สาขา
            $table->text('tax_address')->nullable();                    // ที่อยู่ในใบกำกับ

            // ราคา
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
            $table->decimal('vat_amount', 10, 2)->default(0.00);
            $table->decimal('grand_total', 12, 2)->default(0.00);

            // การชำระเงิน
            $table->string('payment_method')->nullable();               // bank_transfer, credit_card, etc.
            $table->string('payment_status')->default('pending');        // pending, paid, failed, refunded
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_proof')->nullable();                // path to uploaded slip image

            // สถานะคำสั่งซื้อ
            $table->string('status')->default('pending');
            // pending → confirmed → processing → shipped → delivered → completed
            // pending → cancelled

            $table->string('tracking_number')->nullable();              // เลข tracking พัสดุ
            $table->string('shipping_provider')->nullable();            // Kerry, Flash, Thailand Post, etc.
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->text('note')->nullable();                           // หมายเหตุ
            $table->text('admin_note')->nullable();                     // หมายเหตุภายใน (admin)

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('product_name');
            $table->string('image_url')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('row_total', 10, 2)->default(0.00);
            $table->json('options_snapshot')->nullable();                // สำเนาตัวเลือกที่ custom
            $table->boolean('is_preorder')->default(false);
            $table->string('lead_time')->nullable();                    // เช่น "14-21 วันทำการ"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
