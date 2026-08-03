<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('tax_invoice_type')->nullable()->default('none')->after('address'); // none, paper
            $table->string('tax_person_type')->nullable()->after('tax_invoice_type'); // individual, corporate
            $table->string('tax_name')->nullable()->after('tax_person_type');
            $table->string('tax_phone')->nullable()->after('tax_name');
            $table->string('tax_branch')->nullable()->after('tax_phone'); // สำนักงาน/สาขา (corporate only)
            $table->text('tax_address')->nullable()->after('tax_branch');
            $table->text('note')->nullable()->after('tax_address');
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'tax_invoice_type', 'tax_person_type', 'tax_name',
                'tax_phone', 'tax_branch', 'tax_address', 'note',
            ]);
        });
    }
};
