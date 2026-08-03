<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_type_id',
        'occasion_type_id',
        'description',
    ];

    protected $casts = [
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function occasionType(): BelongsTo
    {
        return $this->belongsTo(OccasionType::class);
    }
}
