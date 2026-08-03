<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCustomConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'config_group',
        'available_sizes',
        'show_screen',
        'show_clip',
        'show_step2',
        'show_step3',
        'step2_mode',
        'step3_mode',
        'show_free_parts',
        'allowed_special_parts',
        'free_part_ids',
        'other_part_ids',
        'special_part_ids',
        'standard_colors',
    ];

    protected $casts = [
        'available_sizes'       => 'array',
        'show_screen'           => 'boolean',
        'show_clip'             => 'boolean',
        'show_step2'            => 'boolean',
        'show_step3'            => 'boolean',
        'show_free_parts'       => 'boolean',
        'allowed_special_parts' => 'array',
        'free_part_ids'         => 'array',
        'other_part_ids'        => 'array',
        'special_part_ids'      => 'array',
        'standard_colors'       => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
