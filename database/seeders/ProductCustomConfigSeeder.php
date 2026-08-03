<?php

namespace Database\Seeders;

use App\Models\ProductCustomConfig;
use Illuminate\Database\Seeder;

class ProductCustomConfigSeeder extends Seeder
{
    public function run(): void
    {
        $configs = [
            1 => [
                'config_group'          => 'premium',
                'available_sizes'       => ['10mm', '15mm'],
                'show_screen'           => true,
                'show_clip'             => true,
                'show_step2'            => true,
                'show_step3'            => true,
                'step2_mode'            => 'swatches',
                'step3_mode'            => 'swatches',
                'show_free_parts'       => false,
                'allowed_special_parts' => ['โทรศัพท์', 'กระดุมเรซิ่น', 'Safety', 'เซฟตี้'],
            ],
            8 => [
                'config_group'          => 'premium',
                'available_sizes'       => ['10mm', '15mm'],
                'show_screen'           => true,
                'show_clip'             => true,
                'show_step2'            => true,
                'show_step3'            => true,
                'step2_mode'            => 'swatches',
                'step3_mode'            => 'swatches',
                'show_free_parts'       => false,
                'allowed_special_parts' => ['โทรศัพท์', 'กระดุมเรซิ่น', 'Safety', 'เซฟตี้'],
            ],
            2 => [
                'config_group'          => 'poly_nylon',
                'available_sizes'       => ['10mm', '15mm', '20mm'],
                'show_screen'           => true,
                'show_clip'             => false,
                'show_step2'            => true,
                'show_step3'            => true,
                'step2_mode'            => 'swatches',
                'step3_mode'            => 'swatches',
                'show_free_parts'       => true,
                'allowed_special_parts' => ['เซฟตี้', 'Safety', 'โทรศัพท์', 'กระดุมเรซิ่น', 'ก้ามปู', 'กล้ามปู', 'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับความยาว A', 'ตัวเลื่อนปรับความยาวC', 'ตัวเลื่อนปรับความยาว แบบ C', 'หนีบ', 'บอลกลม'],
            ],
            3 => [
                'config_group'          => 'poly_nylon',
                'available_sizes'       => ['10mm', '15mm', '20mm'],
                'show_screen'           => true,
                'show_clip'             => false,
                'show_step2'            => true,
                'show_step3'            => true,
                'step2_mode'            => 'swatches',
                'step3_mode'            => 'swatches',
                'show_free_parts'       => true,
                'allowed_special_parts' => ['เซฟตี้', 'Safety', 'โทรศัพท์', 'กระดุมเรซิ่น', 'ก้ามปู', 'กล้ามปู', 'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับความยาว A', 'ตัวเลื่อนปรับความยาวC', 'ตัวเลื่อนปรับความยาว แบบ C', 'หนีบ', 'บอลกลม'],
            ],
            4 => [
                'config_group'          => 'sublimation',
                'available_sizes'       => ['10mm', '15mm', '20mm', '25mm'],
                'show_screen'           => true,
                'show_clip'             => false,
                'show_step2'            => false,
                'show_step3'            => true,
                'step2_mode'            => null,
                'step3_mode'            => 'swatches',
                'show_free_parts'       => true,
                'allowed_special_parts' => ['เซฟตี้', 'Safety', 'โทรศัพท์', 'กระดุมเรซิ่น', 'ก้ามปู', 'กล้ามปู', 'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับความยาว A', 'ตัวเลื่อนปรับความยาวC', 'ตัวเลื่อนปรับความยาว แบบ C', 'หนีบ', 'บอลกลม'],
            ],
            5 => [
                'config_group'          => 'recycle',
                'available_sizes'       => ['15mm', '20mm'],
                'show_screen'           => false,
                'show_clip'             => false,
                'show_step2'            => false,
                'show_step3'            => false,
                'step2_mode'            => null,
                'step3_mode'            => null,
                'show_free_parts'       => true,
                'allowed_special_parts' => ['เซฟตี้', 'Safety', 'โทรศัพท์', 'กระดุมเรซิ่น', 'ก้ามปู', 'กล้ามปู', 'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับความยาว A', 'ตัวเลื่อนปรับความยาวC', 'ตัวเลื่อนปรับความยาว แบบ C', 'ตัวเลื่อนปรับความยาวE', 'ตัวเลื่อนปรับความยาว แบบ E', 'หนีบ', 'บอลกลม'],
            ],
            6 => [
                'config_group'          => 'anti_bac',
                'available_sizes'       => ['10mm', '15mm', '20mm', '25mm'],
                'show_screen'           => false,
                'show_clip'             => false,
                'show_step2'            => false,
                'show_step3'            => false,
                'step2_mode'            => null,
                'step3_mode'            => null,
                'show_free_parts'       => true,
                'allowed_special_parts' => ['เซฟตี้', 'Safety', 'โทรศัพท์', 'กระดุมเรซิ่น', 'ก้ามปู', 'กล้ามปู', 'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับความยาว A', 'ตัวเลื่อนปรับความยาวC', 'ตัวเลื่อนปรับความยาว แบบ C', 'หนีบ', 'บอลกลม'],
            ],
            7 => [
                'config_group'          => 'jacquard',
                'available_sizes'       => ['15mm', '20mm'],
                'show_screen'           => false,
                'show_clip'             => false,
                'show_step2'            => true,
                'show_step3'            => true,
                'step2_mode'            => 'text',
                'step3_mode'            => 'text',
                'show_free_parts'       => true,
                'allowed_special_parts' => ['เซฟตี้', 'Safety', 'โทรศัพท์', 'กระดุมเรซิ่น', 'ก้ามปู', 'กล้ามปู', 'ตัวเลื่อนปรับความยาว แบบ A', 'ตัวเลื่อนปรับความยาว A', 'ตัวเลื่อนปรับความยาวC', 'ตัวเลื่อนปรับความยาว แบบ C', 'ตัวเลื่อนปรับความยาวE', 'ตัวเลื่อนปรับความยาว แบบ E', 'หนีบ', 'บอลกลม'],
            ],
            9 => [
                'config_group'          => 'yoyo',
                'available_sizes'       => ['10mm', '15mm'],
                'show_screen'           => true,
                'show_clip'             => false,
                'show_step2'            => true,
                'show_step3'            => true,
                'step2_mode'            => 'swatches',
                'step3_mode'            => 'swatches',
                'show_free_parts'       => true,
                'allowed_special_parts' => [],
            ],
        ];

        foreach ($configs as $productId => $config) {
            ProductCustomConfig::updateOrCreate(
                ['product_id' => $productId],
                $config
            );
        }
    }
}
