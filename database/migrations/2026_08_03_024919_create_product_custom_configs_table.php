<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_custom_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained('products')->cascadeOnDelete();

            // Group identifier
            $table->string('config_group')->comment('e.g. premium, poly_nylon, sublimation, jacquard, yoyo');

            // Available sizes
            $table->json('available_sizes')->comment('e.g. ["10mm","15mm"]');

            // Step visibility & options
            $table->boolean('show_screen')->default(false)->comment('Show screen format option (1side/2side)');
            $table->boolean('show_clip')->default(false)->comment('Show clip color option');
            $table->boolean('show_step2')->default(false)->comment('Show Step 2: rope color selection');
            $table->boolean('show_step3')->default(false)->comment('Show Step 3: screen color selection');
            $table->string('step2_mode')->nullable()->comment('swatches or text');
            $table->string('step3_mode')->nullable()->comment('swatches or text');
            $table->boolean('show_free_parts')->default(true)->comment('Show free parts in Step 4');

            // Allowed special parts (keyword matching)
            $table->json('allowed_special_parts')->nullable()->comment('Keywords to filter special parts');

            // Overridable Part IDs (null = use shared defaults)
            $table->json('free_part_ids')->nullable()->comment('Override free part IDs, null = use shared default');
            $table->json('other_part_ids')->nullable()->comment('Override other part IDs, null = use shared default');
            $table->json('special_part_ids')->nullable()->comment('Override special part IDs, null = use shared default');

            // Overridable standard colors (null = use shared defaults)
            $table->json('standard_colors')->nullable()->comment('Override standard colors, null = use shared default');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_custom_configs');
    }
};
