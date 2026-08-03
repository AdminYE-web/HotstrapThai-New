<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'quotation_id',
        'customer_name',
        'company_name',
        'phone',
        'email',
        'address',
        'tax_invoice_type',
        'tax_person_type',
        'tax_id',
        'tax_name',
        'tax_phone',
        'tax_branch',
        'tax_address',
        'subtotal',
        'shipping_fee',
        'vat_amount',
        'grand_total',
        'payment_method',
        'payment_status',
        'paid_at',
        'payment_proof',
        'status',
        'tracking_number',
        'shipping_provider',
        'shipped_at',
        'delivered_at',
        'note',
        'admin_note',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'shipping_fee'  => 'decimal:2',
        'vat_amount'    => 'decimal:2',
        'grand_total'   => 'decimal:2',
        'paid_at'       => 'datetime',
        'shipped_at'    => 'datetime',
        'delivered_at'  => 'datetime',
    ];

    /**
     * สถานะคำสั่งซื้อที่เป็นไปได้
     */
    const STATUS_PENDING    = 'pending';
    const STATUS_CONFIRMED  = 'confirmed';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPED    = 'shipped';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_COMPLETED  = 'completed';
    const STATUS_CANCELLED  = 'cancelled';

    const PAYMENT_PENDING  = 'pending';
    const PAYMENT_PAID     = 'paid';
    const PAYMENT_FAILED   = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

    /**
     * Relationships
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * สถานะเป็นภาษาไทย
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'รอดำเนินการ',
            'confirmed'  => 'ยืนยันแล้ว',
            'processing' => 'กำลังจัดเตรียม',
            'shipped'    => 'จัดส่งแล้ว',
            'delivered'  => 'ได้รับแล้ว',
            'completed'  => 'เสร็จสมบูรณ์',
            'cancelled'  => 'ยกเลิก',
            default      => $this->status,
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'pending'  => 'รอชำระเงิน',
            'paid'     => 'ชำระแล้ว',
            'failed'   => 'ชำระไม่สำเร็จ',
            'refunded' => 'คืนเงินแล้ว',
            default    => $this->payment_status,
        };
    }

    /**
     * สี badge ตามสถานะ
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'yellow',
            'confirmed'  => 'blue',
            'processing' => 'indigo',
            'shipped'    => 'purple',
            'delivered'  => 'emerald',
            'completed'  => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }

    /**
     * Generate order number: ORD-YYYYMMDD-XXXX
     */
    public static function generateOrderNo(): string
    {
        $dateStr = now()->format('Ymd');
        $last = static::whereDate('created_at', now()->toDateString())->latest()->first();
        $seq = $last ? ((int) substr($last->order_no, -4)) + 1 : 1;
        return 'ORD-' . $dateStr . '-' . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }
}
