<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_name',
        'image_url',
        'quantity',
        'unit_price',
        'options_snapshot',
        'custom_data',
        'is_preorder',
        'lead_time',
        'is_selected',
    ];

    protected $touches = ['cart'];

    protected $casts = [
        'unit_price'       => 'decimal:2',
        'quantity'         => 'integer',
        'options_snapshot' => 'array',
        'custom_data'      => 'array',
        'is_preorder'      => 'boolean',
        'is_selected'      => 'boolean',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getRowTotalAttribute(): float
    {
        if (isset($this->custom_data['subtotal'])) {
            return (float) $this->custom_data['subtotal'];
        }
        return (float) $this->unit_price * $this->quantity;
    }
}
