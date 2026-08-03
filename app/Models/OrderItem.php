<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'image_url',
        'quantity',
        'unit_price',
        'row_total',
        'options_snapshot',
        'is_preorder',
        'lead_time',
    ];

    protected $casts = [
        'unit_price'       => 'decimal:2',
        'row_total'        => 'decimal:2',
        'quantity'         => 'integer',
        'options_snapshot' => 'array',
        'is_preorder'      => 'boolean',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
