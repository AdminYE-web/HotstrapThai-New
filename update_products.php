use App\Models\Product;

Product::where('type', 'ready_to_ship')
    ->where('name', 'like', '%สายคล้องคอ%')
    ->get()
    ->each(function ($p) {
        $p->product_size = '10mm';
        
        // Extract color if exists e.g. (Flag red)
        preg_match('/\((.*?)\)/', $p->name, $matches);
        $color = 'Flag red';
        if (!empty($matches[1])) {
            $color = str_replace('10mm', '', $matches[1]);
            $color = trim(str_replace(')', '', $color));
        }
        
        $p->product_color = $color ?: 'Flag red';
        $p->product_material = 'ผ้าโพลีเอสเตอร์';
        
        if (empty($p->description)) {
            $p->description = "สายคล้องคอพนักงานแบบไม่สกรีน ยาว 45cm(450mm) ขนาด 10mm สี " . $p->product_color . " ตัวสายมีการตัดเย็บอย่างดี มาพร้อมกับตะขอเกี่ยวซองใส่บัตร ไม่มีจำนวนขั้นต่ำในการสั่งซื้อ 1 เส้นก็สั่งได้";
        }
        $p->save();
    });

echo "Updated ready_to_ship lanyards successfully.";
