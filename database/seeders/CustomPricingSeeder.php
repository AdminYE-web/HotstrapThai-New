<?php

namespace Database\Seeders;

use App\Models\CustomPricingRate;
use Illuminate\Database\Seeder;

class CustomPricingSeeder extends Seeder
{
    /**
     * Seed เรทราคาเริ่มต้นสำหรับระบบ Custom ทั้งหมด
     * ราคาเป็น placeholder — แอดมินสามารถปรับได้ใน DB
     */
    public function run(): void
    {
        CustomPricingRate::truncate();

        // ═══════════════════════════════════════════════════
        // 1. ROPE PRICING (scope = 'rope')
        //    key = "{productId}_{size}_{sides}"
        //    ราคาตามประเภทสาย × ขนาด × สกรีน × เรทจำนวน
        // ═══════════════════════════════════════════════════

        $productConfigs = [
            1 => ['name' => 'พรีเมียม',      'base' => 50.00, 'sizes' => ['10mm','15mm'],               'hasScreen' => true],
            2 => ['name' => 'โพลีเอสเตอร์',  'base' => 29.00, 'sizes' => ['10mm','15mm','20mm'],        'hasScreen' => true],
            3 => ['name' => 'ไนลอน',          'base' => 47.00, 'sizes' => ['10mm','15mm','20mm'],        'hasScreen' => true],
            4 => ['name' => 'ซับลิเมชั่น',   'base' => 36.00, 'sizes' => ['10mm','15mm','20mm','25mm'], 'hasScreen' => true],
            5 => ['name' => 'รีไซเคิล',      'base' => 29.00, 'sizes' => ['15mm','20mm'],               'hasScreen' => false],
            6 => ['name' => 'ต้านแบคทีเรีย', 'base' => 60.00, 'sizes' => ['10mm','15mm','20mm','25mm'], 'hasScreen' => false],
            7 => ['name' => 'แจ็คการ์ด',     'base' => 59.00, 'sizes' => ['15mm','20mm'],               'hasScreen' => false],
            8 => ['name' => 'สำเร็จรูป',     'base' => 32.00, 'sizes' => ['10mm','15mm'],               'hasScreen' => true],
            9 => ['name' => 'สายคล้อง+โยโย่','base' => 43.00, 'sizes' => ['10mm','15mm'],        'hasScreen' => true],
        ];

        $sizeMultiplier = ['10mm' => 1.00, '15mm' => 1.10, '20mm' => 1.20, '25mm' => 1.30];
        $screenMultiplier = ['1side' => 1.00, '2side' => 1.20]; // 2 side = +20% per unit
        $qtyTiers = [10 => 1.00, 100 => 0.85, 1000 => 0.70];

        $ropeRows = [];
        foreach ($productConfigs as $pId => $cfg) {
            $screens = $cfg['hasScreen'] ? ['1side', '2side'] : ['1side'];

            foreach ($cfg['sizes'] as $size) {
                foreach ($screens as $screen) {
                    foreach ($qtyTiers as $minQty => $discount) {
                        $price = round($cfg['base'] * $sizeMultiplier[$size] * $screenMultiplier[$screen] * $discount, 2);
                        $sideLabel = $screen === '2side' ? 'สกรีน2ด้าน' : 'สกรีน1ด้าน';
                        $ropeRows[] = [
                            'scope'     => 'rope',
                            'scope_key' => "{$pId}_{$size}_{$screen}",
                            'label'     => "{$cfg['name']} {$size} {$sideLabel}",
                            'min_qty'   => $minQty,
                            'price'     => $price,
                            'fee_type'  => 'per_unit',
                        ];
                    }
                }
            }
        }
        foreach (array_chunk($ropeRows, 50) as $chunk) {
            CustomPricingRate::insert(array_map(fn($r) => array_merge($r, [
                'is_active' => true, 'created_at' => now(), 'updated_at' => now()
            ]), $chunk));
        }

        // ═══════════════════════════════════════════════════
        // 2. ROPE COLOR FEES (scope = 'rope_color')
        // ═══════════════════════════════════════════════════

        $this->insertRates([
            ['scope' => 'rope_color', 'scope_key' => 'extra_standard', 'label' => 'สีเพิ่มปกติ (สีที่ 2+)', 'min_qty' => 1, 'price' => 300.00, 'fee_type' => 'flat'],
            ['scope' => 'rope_color', 'scope_key' => 'special',        'label' => 'สีพิเศษ Pantone',          'min_qty' => 1, 'price' => 1500.00, 'fee_type' => 'flat'],
        ]);

        // ═══════════════════════════════════════════════════
        // 3. SCREEN COLOR FEES (scope = 'screen_color')
        // ═══════════════════════════════════════════════════

        $this->insertRates([
            ['scope' => 'screen_color', 'scope_key' => 'per_color', 'label' => 'ค่าสีสกรีนต่อสี', 'min_qty' => 1, 'price' => 1000.00, 'fee_type' => 'flat'],
        ]);

        // ═══════════════════════════════════════════════════
        // 4. SCREEN BLOCK FEE (scope = 'screen_block')
        //    ค่าบล็อกสกรีน — คิดทุกสายเลย
        // ═══════════════════════════════════════════════════

        $this->insertRates([
            ['scope' => 'screen_block', 'scope_key' => 'all', 'label' => 'ค่าบล็อกสกรีน', 'min_qty' => 1, 'price' => 1500.00, 'fee_type' => 'flat'],
        ]);

        // ═══════════════════════════════════════════════════
        // 5. SAMPLE — ไม่มีค่าบริการ (เก็บแค่สถานะต้องการ/ไม่ต้องการ)
        // ═══════════════════════════════════════════════════

        // ═══════════════════════════════════════════════════
        // 6. EXPRESS DELIVERY (scope = 'express')
        // ═══════════════════════════════════════════════════

        $this->insertRates([
            ['scope' => 'express', 'scope_key' => 'flat',    'label' => 'ค่าจัดส่งด่วน (20-394 เส้น)', 'min_qty' => 20,  'price' => 200.00, 'fee_type' => 'flat'],
            ['scope' => 'express', 'scope_key' => 'percent', 'label' => 'ค่าจัดส่งด่วน (395+ เส้น)',    'min_qty' => 395, 'price' => 10.00,  'fee_type' => 'percent'],
        ]);

        // ═══════════════════════════════════════════════════
        // 7. CUSTOM PART PRICES (scope = 'part')
        //    ราคา parts ในบริบท custom (แตกต่างจากราคาขายตรง)
        //    Free parts = 0, Special parts = ราคาเฉพาะ
        // ═══════════════════════════════════════════════════

        // Free Parts (price 0 in custom)
        $freeParts = [
            82 => 'ตะขอสปริงA (N-1)',
            83 => 'ตะขอสปริงB (N-14)',
            84 => 'ตะขอสปริงดีดทรงรี (N-7)',
            85 => 'ตะขอสปริงดีด (N-4)',
            86 => 'คลิปเหล็กแบบหนีบ (Steel Clip)',
        ];
        foreach ($freeParts as $partId => $label) {
            $this->insertRates([
                ['scope' => 'part', 'scope_key' => "free_{$partId}", 'label' => $label, 'min_qty' => 1, 'price' => 0.00, 'fee_type' => 'per_unit'],
            ]);
        }

        // Other Parts (custom pricing with tiers)
        $otherParts = [
            90  => ['label' => 'คลิปยูโร A (N-15-A)',               'prices' => [10 => 15.00, 100 => 12.75, 1000 => 10.50]],
            91  => ['label' => 'คลิปยูโร B (N-15-B)',               'prices' => [10 => 12.00, 100 => 10.20, 1000 => 8.40]],
            88  => ['label' => 'คลิปหนีบ A (N-10)',                  'prices' => [10 => 6.00,  100 => 5.10,  1000 => 4.20]],
            89  => ['label' => 'ตะขอพีวีซี (N-20)',                  'prices' => [10 => 9.00,  100 => 7.65,  1000 => 6.30]],
            100 => ['label' => 'ตะขอพลาสติก (N-12)',                 'prices' => [10 => 8.00,  100 => 6.80,  1000 => 5.60]],
            98  => ['label' => 'สายห้อยโทรศัพท์มือถือ (แบบถอดได้)', 'prices' => [10 => 5.00,  100 => 4.25,  1000 => 3.50]],
            92  => ['label' => 'คลิปยูโร C (Clip-C)',                'prices' => [10 => 3.00,  100 => 2.55,  1000 => 2.10]],
            93  => ['label' => 'คลิปยูโร (ทรงไม้พาย)',               'prices' => [10 => 4.00,  100 => 3.40,  1000 => 2.80]],
        ];
        foreach ($otherParts as $partId => $data) {
            foreach ($data['prices'] as $minQty => $price) {
                $this->insertRates([
                    ['scope' => 'part', 'scope_key' => "other_{$partId}", 'label' => $data['label'], 'min_qty' => $minQty, 'price' => $price, 'fee_type' => 'per_unit'],
                ]);
            }
        }

        // Special Parts (tiered custom prices)
        $specialParts = [
            96  => ['label' => 'เซฟตี้พาร์ท (Safety)',          'prices' => [1 => 4.00,  100 => 3.50,  1000 => 3.00]],
            97  => ['label' => 'สายห้อยโทรศัพท์มือถือ',          'prices' => [1 => 4.00,  100 => 3.50,  1000 => 3.00]],
            103 => ['label' => 'กระดุมเรซิ่น',                   'prices' => [1 => 30.00, 100 => 25.00, 1000 => 20.00]],
            101 => ['label' => 'ตัวล็อกก้ามปู B_1',              'prices' => [1 => 15.00, 100 => 12.00, 1000 => 10.00]],
            118 => ['label' => 'กล้ามปูB_1',                     'prices' => [1 => 15.00, 100 => 12.00, 1000 => 10.00]],
            104 => ['label' => 'ตัวเลื่อนปรับความยาว A',          'prices' => [1 => 14.00, 100 => 11.50, 1000 => 9.50]],
            119 => ['label' => 'ตัวเลื่อนปรับความยาว แบบ C',      'prices' => [1 => 14.00, 100 => 11.50, 1000 => 9.50]],
            120 => ['label' => 'ตัวเลื่อนปรับความยาว แบบ E',      'prices' => [1 => 14.00, 100 => 11.50, 1000 => 9.50]],
            102 => ['label' => 'ตัวล็อกแบบหนีบ',                 'prices' => [1 => 4.00,  100 => 3.50,  1000 => 3.00]],
            105 => ['label' => 'ตัวเลื่อนปรับระดับสายบอลกลม',     'prices' => [1 => 7.00,  100 => 6.00,  1000 => 5.00]],
        ];
        foreach ($specialParts as $partId => $data) {
            foreach ($data['prices'] as $minQty => $price) {
                $this->insertRates([
                    ['scope' => 'part', 'scope_key' => "special_{$partId}", 'label' => $data['label'], 'min_qty' => $minQty, 'price' => $price, 'fee_type' => 'per_unit'],
                ]);
            }
        }

        // ═══════════════════════════════════════════════════
        // 8. YOYO PRICING (scope = 'yoyo')
        //    Custom context — ราคาแยกตามประเภท × สติ๊กเกอร์ × เรท
        // ═══════════════════════════════════════════════════

        $yoyoTypes = [
            'bw_no_sticker'    => ['label' => 'โยโย่ขาว-ดำ (ไม่ติดสติ๊กเกอร์)', 'prices' => [10 => 19.00, 100 => 16.15, 1000 => 13.30]],
            'bw_sticker'       => ['label' => 'โยโย่ขาว-ดำ (ติดสติ๊กเกอร์)',     'prices' => [10 => 25.00, 100 => 21.25, 1000 => 17.50]],
            'black'            => ['label' => 'โยโย่ดำ (ติดสติ๊กเกอร์ไม่ได้)',    'prices' => [10 => 29.00, 100 => 24.65, 1000 => 20.30]],
            'color_no_sticker' => ['label' => 'โยโย่สี (ไม่ติดสติ๊กเกอร์)',       'prices' => [10 => 25.00, 100 => 21.25, 1000 => 17.50]],
            'color_sticker'    => ['label' => 'โยโย่สี (ติดสติ๊กเกอร์)',          'prices' => [10 => 35.00, 100 => 29.75, 1000 => 24.50]],
        ];
        foreach ($yoyoTypes as $key => $data) {
            foreach ($data['prices'] as $minQty => $price) {
                $this->insertRates([
                    ['scope' => 'yoyo', 'scope_key' => $key, 'label' => $data['label'], 'min_qty' => $minQty, 'price' => $price, 'fee_type' => 'per_unit'],
                ]);
            }
        }

        // ═══════════════════════════════════════════════════
        // 9. CARD HOLDER PRICING (scope = 'card_holder')
        //    ราคาซองใส่บัตรใน custom context (with tiers)
        // ═══════════════════════════════════════════════════

        // Use existing base_price from products table as single-tier price
        // Admin can add more tiers later via DB
    }

    /**
     * Helper to insert rates
     */
    private function insertRates(array $rates): void
    {
        foreach ($rates as $rate) {
            CustomPricingRate::create(array_merge($rate, ['is_active' => true]));
        }
    }
}
