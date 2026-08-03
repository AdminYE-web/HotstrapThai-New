<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quotation_no',
        'customer_name',
        'company_name',
        'phone',
        'email',
        'tax_id',
        'address',
        'tax_invoice_type',
        'tax_person_type',
        'tax_name',
        'tax_phone',
        'tax_branch',
        'tax_address',
        'note',
        'subtotal',
        'shipping_fee',
        'vat_amount',
        'grand_total',
        'status',
    ];

    protected $casts = [
        'subtotal'     => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'vat_amount'   => 'decimal:2',
        'grand_total'  => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Convert grand_total to Thai Baht Text format.
     */
    public function getBahtTextAttribute(): string
    {
        $number = number_format($this->grand_total, 2, '.', '');
        list($baht, $satang) = explode('.', $number);
        
        if ($baht == 0) return 'ศูนย์บาทถ้วน';

        $thaiNums = ['zero' => 'ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
        $thaiUnits = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];

        $convertNumber = function ($numberStr) use ($thaiNums, $thaiUnits) {
            $len = strlen($numberStr);
            $text = '';
            for ($i = 0; $i < $len; $i++) {
                $digit = (int) $numberStr[$i];
                $pos = $len - $i - 1;
                if ($digit !== 0) {
                    if ($pos === 1 && $digit === 1) {
                        $text .= '';
                    } elseif ($pos === 1 && $digit === 2) {
                        $text .= 'ยี่';
                    } elseif ($pos === 0 && $digit === 1 && $len > 1) {
                        $text .= 'เอ็ด';
                    } else {
                        $text .= $thaiNums[$digit];
                    }
                    $text .= $thaiUnits[$pos % 6];
                    if ($pos >= 6 && $pos % 6 === 0) {
                        $text .= 'ล้าน';
                    }
                }
            }
            return $text;
        };

        $result = $convertNumber($baht) . 'บาท';
        if ((int)$satang === 0) {
            $result .= 'ถ้วน';
        } else {
            $result .= $convertNumber($satang) . 'สตางค์';
        }

        return $result;
    }
}
