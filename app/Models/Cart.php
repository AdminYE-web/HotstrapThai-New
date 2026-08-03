<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'shipping_fee',
    ];

    protected $casts = [
        'shipping_fee' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function readyToShipItems(): HasMany
    {
        return $this->hasMany(CartItem::class)->where('is_preorder', false);
    }

    public function preorderItems(): HasMany
    {
        return $this->hasMany(CartItem::class)->where('is_preorder', true);
    }

    public function getSelectedReadyCountAttribute(): int
    {
        return $this->readyToShipItems()->where('is_selected', true)->count();
    }

    public function getSelectedPreorderCountAttribute(): int
    {
        return $this->preorderItems()->where('is_selected', true)->count();
    }

    public function getSelectedTotalCountAttribute(): int
    {
        return $this->items()->where('is_selected', true)->count();
    }

    public function getSelectedSubtotalAttribute(): float
    {
        return $this->items()
            ->where('is_selected', true)
            ->get()
            ->sum(fn($item) => $item->row_total);
    }

    public function getGrandTotalAttribute(): float
    {
        return $this->selected_subtotal + (float) $this->shipping_fee;
    }
}
