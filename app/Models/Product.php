<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // ─── Accessors (ให้เรียกข้อมูลจากตารางย่อยได้เหมือนเดิม) ───

    public function getTypeAttribute()
    {
        return $this->detail?->productType?->slug;
    }

    public function getDescriptionAttribute()
    {
        return $this->detail?->description;
    }

    public function getOccasionTypeAttribute()
    {
        return $this->detail?->occasionType?->slug;
    }

    public function getSpecsAttribute()
    {
        return $this->variants->first()?->specs ?? [];
    }

    public function getStockQtyAttribute()
    {
        // 1. Calculate physical total stock
        if ($this->relationLoaded('variants')) {
            $totalStock = $this->variants->sum('stock_qty');
        } else {
            $totalStock = $this->variants()->sum('stock_qty');
        }

        // 2. Subtract reserved stock (items in active carts)
        $reservedStock = \App\Models\CartItem::where('product_id', $this->id)
            ->where('is_preorder', false)
            ->whereHas('cart', function($q) {
                // Cart updated within last 15 mins
                $q->where('updated_at', '>=', now()->subMinutes(15));
            })
            ->sum('quantity');

        return max(0, $totalStock - $reservedStock);
    }

    public function getProductSizeAttribute()
    {
        return $this->variants->first()?->product_size;
    }

    public function getProductColorAttribute()
    {
        return $this->variants->first()?->product_color;
    }

    public function getProductMaterialAttribute()
    {
        return $this->variants->first()?->product_material;
    }



    // ─── Relationships ───

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class)->orderBy('min_qty', 'asc');
    }

    public function customConfig(): HasOne
    {
        return $this->hasOne(ProductCustomConfig::class);
    }

    // Backward compatibility accessor
    public function getPriceTiersAttribute()
    {
        return $this->prices;
    }

    /**
     * คำนวณราคาตามจำนวนสั่งซื้อ
     * หา price ที่ min_qty ตรงกับจำนวน
     * ถ้าไม่มี → ใช้ base_price
     */
    public function getPriceForQty(int $qty): float
    {
        $prices = $this->relationLoaded('prices')
            ? $this->prices
            : $this->prices()->get();

        if ($prices->isEmpty()) {
            return (float) $this->base_price;
        }

        $matched = $prices->where('min_qty', '<=', $qty)
            ->sortByDesc('min_qty')
            ->first();

        return $matched ? (float) $matched->price : (float) $this->base_price;
    }
}
