<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════
        // 1. Create Categories
        // ══════════════════════════════════════════
        $categoriesData = [
            ['name' => 'สายคล้องสั่งทำ', 'slug' => 'custom-lanyards'],
            ['name' => 'สายคล้องคอ', 'slug' => 'neck-lanyards'],
            ['name' => 'สายคล้องอื่น ๆ', 'slug' => 'other-lanyards'],
            ['name' => 'กรอบ/ซองใส่บัตร', 'slug' => 'badge-holders'],
            ['name' => 'โยโย่ห้อยบัตร', 'slug' => 'yoyo-badge-holders'],
            ['name' => 'พาร์ทสายคล้องคอ', 'slug' => 'lanyard-parts'],
            ['name' => 'คาราบิเนอร์', 'slug' => 'carabiners'],
        ];

        $categories = [];
        foreach ($categoriesData as $c) {
            $categories[$c['slug']] = Category::firstOrCreate(['slug' => $c['slug']], $c);
        }

        // ══════════════════════════════════════════
        // 2. Image Mappings
        // ══════════════════════════════════════════
        $imageMap = [
            'สายคล้อง + โยโย่' => 'images/products/lanyard-snap-yoyo.png',
            'สายคล้องคอ Snap yoyo' => 'images/products/lanyard-snap-yoyo.png',
            'สายคล้องคอติดโลโก้เรซิ่น' => 'images/products/lanyard-resin-logo.png',
            'สายคล้องคอต้านเชื้อแบคทีเรีย' => 'images/products/lanyard-antibacterial.png',
            'สายคล้องคอผ้าแจ็คการ์ด' => 'images/products/lanyard-jacquard.png',
            'สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น' => 'images/products/lanyard-sublimation.png',
            'สายคล้องคอพนักงานผ้าโพลีเอสเตอร์' => 'images/products/lanyard-polyester.png',
            'สายคล้องคอพนักงานผ้าไนลอน' => 'images/products/lanyard-nylon.png',
            'สายคล้องคอพนักงานแบบพรีเมียม' => 'images/products/lanyard-premium.png',
            'สายคล้องคอโทรศัพท์' => 'images/products/phone-lanyard-holder.png',
            'สายคล้องมือถือ' => 'images/products/wristband-event.png',
            'ID-STD-1(พลาสติก)' => 'images/products/acc-badge-holder.png',
            'ID-STD-2(พลาสติก)' => 'images/products/acc-badge-holder.png',
            'ID-STD-3(พลาสติก)' => 'images/products/acc-badge-holder.png',
            'โยโย่ดำ' => 'images/products/acc-yoyo.png',
            'โยโย่ขาว' => 'images/products/acc-yoyo.png',
            'Snap yoyo' => 'images/products/acc-parts.png',
            'คาราบิเนอร์ แบบเงา : Ruby Red' => 'images/products/acc-carabiner.png',
            'คาราบิเนอร์ แบบเงา : Black' => 'images/products/acc-carabiner.png',
            'คาราบิเนอร์ แบบเงา : Silver' => 'images/products/acc-carabiner.png',
        ];

        // Occasion Mappings
        $officeItems = ['สายคล้องคอพนักงานผ้าโพลีเอสเตอร์', 'สายคล้องคอ Snap yoyo', 'ID-STD-1(พลาสติก)', 'โยโย่ดำ', 'สายคล้อง + โยโย่'];
        $schoolItems = ['สายคล้องคอพนักงานแบบชุดสำเร็จรูป', 'สายคล้องคอต้านเชื้อแบคทีเรีย'];
        $eventItems = ['สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น', 'สายคล้องมือถือ', 'คาราบิเนอร์ แบบเงา : Ruby Red'];

        $productIndex = 1;

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม A: สายคล้องสั่งทำ (Custom Lanyards) — 15 รายการ
        // ══════════════════════════════════════════════════════════════
        $customLanyards = [
            'สายคล้องคอพนักงานแบบพรีเมียม',
            'สายคล้องคอพนักงานผ้าโพลีเอสเตอร์',
            'สายคล้องคอพนักงานผ้าไนลอน',
            'สายคล้องคอพนักงานสกรีนแบบซับลิเมชั่น',
            'สายคล้องบัตรรีไซเคิล',
            'สายคล้องคอต้านเชื้อแบคทีเรีย',
            'สายคล้องคอผ้าแจ็คการ์ด',
            'สายคล้องคอพนักงานแบบชุดสำเร็จรูป',
            'สายคล้อง + โยโย่',
            'สายคล้องคอซิลิโคน(สกรีนลาย)',
            'สายคล้องคอ Snap yoyo',
            'สายคล้องคอติดโลโก้เรซิ่น',
            'สายคล้องคอบัตรสะท้อนแสง',
            'สายคล้องบัตรหนัง PU',
            'สายคล้องคอเหรียญรางวัลอะคริลิค',
        ];

        foreach ($customLanyards as $name) {
            $occasion = null;
            if (in_array($name, $officeItems)) $occasion = 'office';
            elseif (in_array($name, $schoolItems)) $occasion = 'school';
            elseif (in_array($name, $eventItems)) $occasion = 'event';

            $price = rand(25, 60);
            $product = $this->createProduct($categories['custom-lanyards'], $name, $price, $productIndex++);
            $this->createDetail($product, 'custom', $occasion, "{$name} คุณภาพมาตรฐาน HOT STRAP ผลิตด้วยวัสดุเกรดพรีเมียม");
            $this->createVariant($product, 0);
            $this->createSinglePrice($product, $price);
            $this->createImage($product, $imageMap[$name] ?? null);
        }

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม B: สายคล้องคอ ready_to_ship (Neck Lanyards) — 6 รายการ
        // ══════════════════════════════════════════════════════════════
        $readyToShipLanyards = [
            [
                'name' => 'สายคล้องคอผ้าโพลีเอสเตอร์(ไม่สกรีนลาย)-Flag red(10mm)',
                'size' => '10mm', 'color' => 'Flag red', 'material' => 'ผ้าโพลีเอสเตอร์',
                'description' => 'สายคล้องคอพนักงานแบบไม่สกรีน ยาว 45cm(450mm) ขนาด 10mm สี Flag red ตัวสายมีการตัดเย็บอย่างดี มาพร้อมกับตะขอเกี่ยวซองใส่บัตร ไม่มีจำนวนขั้นต่ำในการสั่งซื้อ 1 เส้นก็สั่งได้',
                'stock' => 11,
            ],
            [
                'name' => 'สายคล้องคอผ้าโพลีเอสเตอร์(ไม่สกรีนลาย)-293C(10mm)',
                'size' => '10mm', 'color' => '293C', 'material' => 'ผ้าโพลีเอสเตอร์',
                'description' => 'สายคล้องคอพนักงานแบบไม่สกรีน ยาว 45cm(450mm) ขนาด 10mm สี 293C ตัวสายมีการตัดเย็บอย่างดี มาพร้อมกับตะขอเกี่ยวซองใส่บัตร ไม่มีจำนวนขั้นต่ำในการสั่งซื้อ',
                'stock' => 0,
            ],
            [
                'name' => 'สายคล้องคอผ้าโพลีเอสเตอร์(ไม่สกรีนลาย)-Black(10mm)',
                'size' => '10mm', 'color' => 'Black', 'material' => 'ผ้าโพลีเอสเตอร์',
                'description' => 'สายคล้องคอพนักงานแบบไม่สกรีน ยาว 45cm(450mm) ขนาด 10mm สี Black ตัวสายมีการตัดเย็บอย่างดี มาพร้อมกับตะขอเกี่ยวซองใส่บัตร ไม่มีจำนวนขั้นต่ำในการสั่งซื้อ',
                'stock' => 0,
            ],
            [
                'name' => 'สายคล้องคอผ้าโพลีเอสเตอร์(ไม่สกรีนลาย)-348C(10mm)',
                'size' => '10mm', 'color' => '348C', 'material' => 'ผ้าโพลีเอสเตอร์',
                'description' => 'สายคล้องคอพนักงานแบบไม่สกรีน ยาว 45cm(450mm) ขนาด 10mm สี 348C ตัวสายมีการตัดเย็บอย่างดี มาพร้อมกับตะขอเกี่ยวซองใส่บัตร ไม่มีจำนวนขั้นต่ำในการสั่งซื้อ',
                'stock' => 0,
            ],
            [
                'name' => 'สายคล้องคอซิลิโคน(ไม่สกรีนลาย)-น้ำเงิน(10mm)',
                'size' => '10mm', 'color' => 'น้ำเงิน', 'material' => 'ซิลิโคน',
                'description' => 'สายคล้องบัตรซิลิโคน แบบไม่สกรีนโลโก้พร้อมส่ง 1 เส้นก็สามารถสั่งซื้อได้ มาพร้อมกับตะขอเกี่ยวซองใส่บัตรและตัวคล้องโทรศัพท์ สายสามารถเช็ดล้างทำความสะอาดได้โดยไม่เกิดความเสียหาย บิดงอได้สามารถคืนรูปได้ ไม่ฉีดขาดง่ายเหมือนซิลิโคนราคาถูก ใช้งานทนทาน',
                'stock' => 0,
            ],
            [
                'name' => 'สายคล้องคอซิลิโคน(ไม่สกรีนลาย)-ชมพู(10mm)',
                'size' => '10mm', 'color' => 'ชมพู', 'material' => 'ซิลิโคน',
                'description' => 'สายคล้องบัตรซิลิโคน แบบไม่สกรีนโลโก้พร้อมส่ง 1 เส้นก็สามารถสั่งซื้อได้ มาพร้อมกับตะขอเกี่ยวซองใส่บัตรและตัวคล้องโทรศัพท์ สายสามารถเช็ดล้างทำความสะอาดได้โดยไม่เกิดความเสียหาย บิดงอได้สามารถคืนรูปได้ ไม่ฉีดขาดง่ายเหมือนซิลิโคนราคาถูก ใช้งานทนทาน',
                'stock' => 0,
            ],
        ];

        foreach ($readyToShipLanyards as $item) {
            $product = $this->createProduct($categories['neck-lanyards'], $item['name'], 15.00, $productIndex++);
            $this->createDetail($product, 'ready_to_ship', null, $item['description']);
            $this->createVariant($product, $item['stock'], $item['size'], $item['color'], $item['material']);
            $this->createSinglePrice($product, 15.00);
            $this->createImage($product, $imageMap[$item['name']] ?? null);
        }

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม C: สายคล้องอื่น ๆ (Other Lanyards) — 2 รายการ
        // ══════════════════════════════════════════════════════════════
        $otherLanyards = ['สายคล้องคอโทรศัพท์', 'สายคล้องมือถือ'];
        foreach ($otherLanyards as $name) {
            $occasion = in_array($name, $eventItems) ? 'event' : null;
            $product = $this->createProduct($categories['other-lanyards'], $name, 15.00, $productIndex++);
            $this->createDetail($product, 'contact', $occasion, "{$name} คุณภาพมาตรฐาน HOT STRAP");
            $this->createVariant($product, 0);
            $this->createSinglePrice($product, 15.00);
            $this->createImage($product, $imageMap[$name] ?? null);
        }

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม D: กรอบ/ซองใส่บัตร (Badge Holders) — 4 ประเภทย่อย
        // ══════════════════════════════════════════════════════════════

        // D1: ซองใส่บัตรแบบอ่อน (พลาสติก) — ID-STD ราคาเดียว 7 บาท
        $idStdItems = ['ID-STD-1(พลาสติก)', 'ID-STD-2(พลาสติก)', 'ID-STD-3(พลาสติก)'];
        $idStdSpecs = ['ประเภท' => 'ซองใส่บัตรพนักงานแบบอ่อน', 'วัสดุ' => 'พลาสติก'];
        foreach ($idStdItems as $name) {
            $product = $this->createProduct($categories['badge-holders'], $name, 7.00, $productIndex++);
            $this->createDetail($product, 'ready_to_ship', in_array($name, $officeItems) ? 'office' : null,
                'ซองใส่บัตรพนักงานแบบอ่อน (พลาสติก) ราคา 7 บาท แถมฟรีเมื่อสั่งซื้อสายคล้องบัตร 300 ชิ้นขึ้นไป');
            $this->createVariant($product, 11, null, null, null, $idStdSpecs);
            $this->createSinglePrice($product, 7.00);
            $this->createImage($product, $imageMap[$name] ?? null);
            // ID-STD ราคาเดียว ไม่มี price tiers
        }

        // D2: ซองใส่บัตรแบบอ่อน (PVC) — มี price tiers
        $pvcItems = [
            'ID-1_N(PVC)', 'ID-1_NZ(PVC)', 'ID-2_N(PVC)', 'ID-3_N(PVC)',
            'ID-4_N(PVC)', 'ID-4_NZ(PVC)', 'ID-5_NZ(PVC)', 'ID-6_N(PVC)',
            'ID-6_NZ(PVC)', 'ID-8_N(PVC)', 'ID-9_N(PVC)',
        ];
        $pvcDescription = 'ซองใส่บัตรพนักงาน PVC แบบอ่อนใช้สำหรับใส่บัตรพนักงานและเนมการ์ดต่างๆ';
        $pvcSpecs = [
            'รูปแบบ' => 'ซองใส่บัตรแนวนอน เคสแบบอ่อน',
            'ขนาดซอง' => '87mm x 100mm',
            'ขนาดบัตร' => '64mm x 92mm',
            'รูซ้าย-ขวา' => 'เส้นผ่านศูนย์กลาง 4.5mm',
            'รูกลาง' => 'กว้าง 14mm สูง 4.5mm',
            'วัสดุ' => 'ไวนิล(หนา: 0.25mm)',
        ];
        foreach ($pvcItems as $name) {
            $product = $this->createProduct($categories['badge-holders'], $name, 30.00, $productIndex++);
            $this->createDetail($product, 'ready_to_ship', null, $pvcDescription);
            $this->createVariant($product, 11, null, null, 'ไวนิล(หนา: 0.25mm)', $pvcSpecs);
            $this->createImage($product, null);
            $this->createPrices($product, [[1, 30.00], [100, 20.00], [1000, 15.00]]);
        }

        // D3: ซองใส่บัตรแบบหนัง PU — มี price tiers
        $puItems = [
            'ID_PU_Black', 'ID_PU_White', 'ID_PU_Gray', 'ID_PU_Blue',
            'ID_PU_Skyblue', 'ID_PU_Brown', 'ID_PU_Cream', 'ID_PU_Green',
            'ID_PU_Lightgreen', 'ID_PU_Navy', 'ID_PU_Orange', 'ID_PU_Pink',
            'ID_PU_Red', 'ID_PU_Yellow',
        ];
        $puDescription = 'ซองใส่บัตรพนักงานแบบหนัง PU';
        $puSpecs = [
            'รูปแบบ' => 'ซองใส่บัตรแนวตั้ง',
            'ขนาดนามบัตร' => '90mm x 55mm',
            'ขนาดรอบนอก' => '110mm x 70mm',
            'วัสดุ' => 'หนัง PU',
        ];
        foreach ($puItems as $name) {
            $color = str_replace('ID_PU_', '', $name);
            $product = $this->createProduct($categories['badge-holders'], $name, 30.00, $productIndex++);
            $specsWithColor = array_merge($puSpecs, ['สี' => $color]);
            $this->createDetail($product, 'ready_to_ship', null, $puDescription);
            $this->createVariant($product, 11, null, $color, 'หนัง PU', $specsWithColor);
            $this->createImage($product, null);
            $this->createPrices($product, [[1, 30.00], [100, 20.00], [1000, 15.00]]);
        }

        // D4: ซองใส่บัตร Sliding Plastic PP — มี price tiers
        $slidingItems = [
            'ID_CARD Sliding Plastic PP - Green',
            'ID_CARD Sliding Plastic PP - Blue Gray',
            'ID_CARD Sliding Plastic PP - White',
            'ID_CARD Sliding Plastic PP - Red',
            'ID_CARD Sliding Plastic PP - Gray',
            'ID_CARD Sliding Plastic PP - Yellow',
            'ID_CARD Sliding Plastic PP - Blue',
            'ID_CARD Sliding Plastic PP - Orange',
            'ID_CARD Sliding Plastic PP - Pink',
            'ID_CARD Sliding Plastic PP - Sky Blue',
            'ID_CARD Sliding Plastic PP - Black',
        ];
        $slidingDescription = 'ซองใส่บัตรพนักงานแบบ Sliding Plastic';
        $slidingSpecs = [
            'รูปแบบ' => 'ซองใส่บัตรแนวตั้ง',
            'ขนาดนามบัตร' => '85mm x 54mm',
            'ขนาดรอบนอก' => '110mm x 69mm',
            'วัสดุ' => 'Plastic PP',
        ];
        foreach ($slidingItems as $name) {
            $color = str_replace('ID_CARD Sliding Plastic PP - ', '', $name);
            $product = $this->createProduct($categories['badge-holders'], $name, 30.00, $productIndex++);
            $specsWithColor = array_merge($slidingSpecs, ['สี' => $color]);
            $this->createDetail($product, 'ready_to_ship', null, $slidingDescription);
            $this->createVariant($product, 11, null, $color, 'Plastic PP', $specsWithColor);
            $this->createImage($product, null);
            $this->createPrices($product, [[1, 30.00], [100, 20.00], [1000, 15.00]]);
        }

        // D5: ซองใส่บัตรแบบกรอบแข็ง — มี price tiers
        $hardFrameItems = ['F001', 'F002', 'F003', 'F004'];
        $hardFrameDescription = 'กรอบใส่บัตรแบบแข็ง ขนาดเหมาะสำหรับบัตรประชาชนหรือนามบัตรขนาดมาตราฐาน แข็งแรงทนทาน ใช้งานได้นาน';
        $hardFrameSpecs = [
            'ประเภท' => 'เคสแบบกรอบแข็ง',
            'รูปแบบ' => 'ใส่นามบัตรแนวตั้ง',
            'ขนาดแนวตั้ง' => '86mm',
            'ขนาดแนวนอน' => '54mm',
        ];
        foreach ($hardFrameItems as $name) {
            $product = $this->createProduct($categories['badge-holders'], $name, 30.00, $productIndex++);
            $this->createDetail($product, 'ready_to_ship', null, $hardFrameDescription);
            $this->createVariant($product, 200, null, null, 'กรอบแข็ง', $hardFrameSpecs);
            $this->createImage($product, null);
            $this->createPrices($product, [[1, 30.00], [100, 20.00], [1000, 15.00]]);
        }

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม E: โยโย่ห้อยบัตร (Yoyo Badge Holders) — 13 รายการ
        // ══════════════════════════════════════════════════════════════
        $yoyoItems = [
            'โยโย่ดำ', 'โยโย่ขาว', 'สต็อปเปอร์โยโย่-สีดำ',
            'คาราบิเนอร์โยโย่ - สีแดงทึบ', 'คาราบิเนอร์โยโย่ - สีขาวทึบ',
            'คาราบิเนอร์โยโย่ - สีดำทึบ', 'คาราบิเนอร์โยโย่ - สีดำโปร่งใส',
            'คาราบิเนอร์โยโย่ - สีนำเงินโปร่งใส', 'คาราบิเนอร์โยโย่ - สีฟ้าโปร่งใส',
            'คาราบิเนอร์โยโย่ - สีเขียวโปร่งใส', 'คาราบิเนอร์โยโย่ - สีเหลืองโปร่งใส',
            'คาราบิเนอร์โยโย่ - สีม่วงโปร่งใส', 'คาราบิเนอร์โยโย่ - สีแดงโปร่งใส',
        ];
        foreach ($yoyoItems as $name) {
            $isReadyToShip = in_array($name, ['โยโย่ดำ', 'โยโย่ขาว']);
            $type = $isReadyToShip ? 'ready_to_ship' : 'contact';
            $stock = $isReadyToShip ? 500 : 0;
            $price = rand(18, 45);
            $occasion = in_array($name, $officeItems) ? 'office' : null;
            $product = $this->createProduct($categories['yoyo-badge-holders'], $name, $price, $productIndex++);
            $this->createDetail($product, $type, $occasion, "{$name} คุณภาพมาตรฐาน HOT STRAP");
            $this->createVariant($product, $stock);
            $this->createSinglePrice($product, $price);
            $this->createImage($product, $imageMap[$name] ?? null);
        }

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม F: พาร์ทสายคล้องคอ (Lanyard Parts) — 31 รายการ
        // ══════════════════════════════════════════════════════════════
        $lanyardParts = [
            'คลิปโลโก้เรซิ่น Front Keeper', 'Snap yoyo',
            'ตะขอสปริงA', 'ตะขอสปริงB', 'ตะขอสปริงดีดทรงรี', 'ตะขอสปริงดีด',
            'คลิปเหล็กแบบหนีบ', 'คลิปเหล็กแบบหนีบ+พีวีซี', 'คลิปหนีบ A',
            'ตะขอพีวีซี', 'คลิปยูโร A', 'คลิปยูโร B', 'คลิปยูโร C',
            'คลิปยูโร(ทรงไม้พาย)', 'คลิปโลโกเรซิ่น (สีขาว)', 'คลิปโลโกเรซิ่น (สีดำ)',
            'Safety part', 'สายห้อยโทรศัพท์มือถือ',
            'สายห้อยโทรศัพท์มือถือ (แบบถอดได้)', 'สายห้อยโทรศัพท์มือถือ (แบบชิ้นเดียว)',
            'ตะขอพลาสติก', 'ตัวล็อกก้ามปู', 'ตัวล็อกแบบหนีบ', 'กระดุมเรซิ่น',
            'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับระดับสายบอลกลม',
            'ตะขอแมสแบบ A', 'ตะขอแมสแบบ B',
            'ตัวคล้องขวดน้ำ แบบอลูมิเนียม', 'ตัวคล้องขวดน้ำแบบยาง A',
            'ตัวคล้องขวดน้ำแบบยาง B', 'PET Holder TypeC',
            'กล้ามปูB_1', 'ตัวเลื่อนปรับความยาว แบบ C', 'ตัวเลื่อนปรับความยาว แบบ E',
        ];
        foreach ($lanyardParts as $name) {
            $price = rand(3, 15);
            $product = $this->createProduct($categories['lanyard-parts'], $name, $price, $productIndex++);
            $this->createDetail($product, 'parts', null, "{$name} อะไหล่สายคล้องคอ HOT STRAP");
            $this->createVariant($product, 5000);
            $this->createSinglePrice($product, $price);
            $this->createImage($product, $imageMap[$name] ?? null);
        }

        // ══════════════════════════════════════════════════════════════
        // กลุ่ม G: คาราบิเนอร์ (Carabiners) — 6 รายการ
        // ══════════════════════════════════════════════════════════════
        $carabiners = [
            'คาราบิเนอร์ แบบเงา : Ruby Red', 'คาราบิเนอร์ แบบเงา : Black',
            'คาราบิเนอร์ แบบเงา : Silver', 'คาราบิเนอร์ แบบด้าน : Ruby Red',
            'คาราบิเนอร์ แบบด้าน : Black', 'คาราบิเนอร์ แบบด้าน : Silver',
        ];
        foreach ($carabiners as $name) {
            $price = rand(12, 25);
            $occasion = in_array($name, $eventItems) ? 'event' : null;
            $product = $this->createProduct($categories['carabiners'], $name, $price, $productIndex++);
            $this->createDetail($product, 'contact', $occasion, "{$name} คุณภาพมาตรฐาน HOT STRAP");
            $this->createVariant($product, 0);
            $this->createSinglePrice($product, $price);
            $this->createImage($product, $imageMap[$name] ?? null);
        }
    }

    // ─── Helper Methods ───

    private function createProduct(Category $category, string $name, float $price, int $index): Product
    {
        $slugBase = Str::slug($name);
        if (empty($slugBase)) $slugBase = 'prod-' . $index;
        $slug = $slugBase . '-' . $index . '-' . rand(100, 999);

        return Product::create([
            'category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'base_price' => $price,
            'is_active' => true,
        ]);
    }

    private function createDetail(Product $product, string $type, ?string $occasion, string $description): void
    {
        $typeId = \Illuminate\Support\Facades\DB::table('product_types')->where('slug', $type)->value('id');
        $occasionId = $occasion ? \Illuminate\Support\Facades\DB::table('occasion_types')->where('slug', $occasion)->value('id') : null;

        ProductDetail::create([
            'product_id' => $product->id,
            'product_type_id' => $typeId,
            'occasion_type_id' => $occasionId,
            'description' => $description,
        ]);
    }

    private function createVariant(
        Product $product, int $stock,
        ?string $size = null, ?string $color = null, ?string $material = null,
        array $extraSpecs = []
    ): void {
        $specs = $extraSpecs;
        if ($size) $specs['ขนาด'] = $size;
        if ($color) $specs['สี'] = $color;
        if ($material) $specs['วัสดุ'] = $material;

        ProductVariant::create([
            'product_id' => $product->id,
            'sku' => $product->slug,
            'product_size' => $size,
            'product_color' => $color,
            'product_material' => $material,
            'stock_qty' => $stock,
            'specs' => empty($specs) ? null : $specs,
        ]);
    }

    private function createImage(Product $product, ?string $imagePath): void
    {
        if ($imagePath) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_primary' => true,
            ]);
        }
    }

    private function createPrices(Product $product, array $tiers): void
    {
        foreach ($tiers as [$minQty, $price]) {
            ProductPrice::create([
                'product_id' => $product->id,
                'min_qty' => $minQty,
                'price' => $price,
            ]);
        }
    }

    /**
     * สร้างราคาเดียว (สินค้าที่ไม่มีเงื่อนไขราคาตามจำนวน)
     */
    private function createSinglePrice(Product $product, float $price): void
    {
        ProductPrice::create([
            'product_id' => $product->id,
            'min_qty' => 1,
            'price' => $price,
        ]);
    }
}
