<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_id',
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'options_snapshot',
        'is_preorder',
        'lead_time',
        'row_total',
    ];

    protected $casts = [
        'quantity'         => 'integer',
        'unit_price'       => 'decimal:2',
        'row_total'        => 'decimal:2',
        'options_snapshot' => 'array',
        'is_preorder'      => 'boolean',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
