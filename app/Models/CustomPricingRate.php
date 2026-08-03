<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPricingRate extends Model
{
    protected $fillable = [
        'scope', 'scope_key', 'label', 'min_qty', 'price', 'fee_type', 'is_active',
    ];

    protected $casts = [
        'min_qty'   => 'integer',
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * ดึงราคา per-unit ตามเงื่อนไข (เลือกเรทที่ตรงกับจำนวน)
     */
    public static function getRate(string $scope, string $scopeKey, int $qty): ?float
    {
        $rate = static::where('scope', $scope)
            ->where('scope_key', $scopeKey)
            ->where('fee_type', 'per_unit')
            ->where('min_qty', '<=', $qty)
            ->where('is_active', true)
            ->orderByDesc('min_qty')
            ->first();

        return $rate ? (float) $rate->price : null;
    }

    /**
     * ดึงค่าธรรมเนียมแบบ flat fee
     */
    public static function getFlatFee(string $scope, string $scopeKey): float
    {
        $rate = static::where('scope', $scope)
            ->where('scope_key', $scopeKey)
            ->where('fee_type', 'flat')
            ->where('is_active', true)
            ->first();

        return $rate ? (float) $rate->price : 0;
    }

    /**
     * ดึงเรทราคาทั้งหมดของ scope + key
     */
    public static function getTiers(string $scope, string $scopeKey): array
    {
        return static::where('scope', $scope)
            ->where('scope_key', $scopeKey)
            ->where('is_active', true)
            ->orderBy('min_qty')
            ->get()
            ->toArray();
    }

    /**
     * ดึงราคาทั้งหมดเป็น JSON สำหรับ frontend
     */
    public static function getAllRatesForFrontend(): array
    {
        return static::where('is_active', true)
            ->orderBy('scope')
            ->orderBy('scope_key')
            ->orderBy('min_qty')
            ->get()
            ->groupBy('scope')
            ->map(function ($scopeRates) {
                return $scopeRates->groupBy('scope_key')->map(function ($keyRates) {
                    return $keyRates->map(function ($r) {
                        return [
                            'min_qty'  => $r->min_qty,
                            'price'    => (float) $r->price,
                            'fee_type' => $r->fee_type,
                            'label'    => $r->label,
                        ];
                    })->values();
                });
            })
            ->toArray();
    }
}
