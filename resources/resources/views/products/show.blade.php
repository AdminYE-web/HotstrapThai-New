<x-app-layout>
    <div class="bg-[#F8F9FA] py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center space-x-2 text-[13px] text-[#686868] mb-6">
                <a href="{{ route('home') }}" class="hover:text-[#004998] transition-colors">หน้าแรก</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" class="hover:text-[#004998] transition-colors">สินค้าทั้งหมด</a>
                <span>/</span>
                <span class="text-[#000000] font-medium">{{ $product->name }}</span>
            </nav>

            <!-- Product Detail Container (Card) -->
            <div class="bg-white border border-[#E4E4E4] rounded-2xl p-6 sm:p-10 shadow-xs grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-start mb-12">
                
                <!-- Left Column: Product Image Gallery -->
                <div class="space-y-4">
                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-2xl p-6 border border-[#E4E4E4] flex items-center justify-center overflow-hidden relative">
                        @if ($product->primaryImage)
                            <img src="{{ asset($product->primaryImage->image_path) }}?v={{ time() }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain" />
                        @else
                            <img src="{{ asset('images/products/lanyard-snap-yoyo.png') }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain" />
                        @endif

                        <!-- Badge Overlay -->
                        <div class="absolute top-4 left-4 flex flex-col gap-1.5 z-10">
                            @if ($product->stock_qty <= 0 && $product->type !== 'custom')
                                <span class="bg-[#E53935] text-white text-[12px] font-bold px-3 py-1 rounded-full shadow-xs">
                                    สินค้าหมด
                                </span>
                            @elseif ($product->type === 'ready_to_ship')
                                <span class="bg-[#2E7D32] text-white text-[12px] font-bold px-3 py-1 rounded-full shadow-xs">
                                    สินค้าพร้อมส่ง
                                </span>
                            @elseif ($product->type === 'custom')
                                <span class="bg-[#004998] text-white text-[12px] font-bold px-3 py-1 rounded-full shadow-xs">
                                    สั่งทำพิเศษ
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Product Information & Action -->
                <div class="space-y-6">
                    <div>
                        <span class="inline-block bg-[#F3F3F3] text-[#004998] text-[12px] font-bold px-3 py-1 rounded-md mb-2">
                            {{ $product->category->name ?? 'สินค้าทั่วไป' }}
                        </span>
                        <h1 class="text-[24px] sm:text-[30px] font-bold text-[#000000] leading-tight">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <!-- Price Box -->
                    <div class="bg-[#F8F9FA] p-4 rounded-xl border border-[#E4E4E4] flex items-baseline gap-3">
                        <span class="text-[13px] text-[#686868] font-medium">ราคาเริ่มต้น:</span>
                        <span class="text-[28px] sm:text-[32px] font-extrabold text-[#004998]">
                            ฿{{ number_format($product->base_price, 2) }}
                        </span>
                        <span class="text-[12px] text-gray-500">*ราคาต่อชิ้น (ขึ้นอยู่กับจำนวนสั่งซื้อ)</span>
                    </div>

                    <!-- Product Description -->
                    <div class="space-y-2">
                        <h3 class="text-[15px] font-bold text-black">รายละเอียดสินค้า</h3>
                        <p class="text-[14px] text-[#686868] leading-relaxed">
                            {{ $product->description ?? 'สายคล้องคอและอุปกรณ์คุณภาพสูง ผลิตจากวัสดุเกรดพรีเมียม สวมใส่สบาย มีความทนทานสูง รองรับงานสกรีนลายและงานพิมพ์ฟูลคัลเลอร์' }}
                        </p>
                    </div>

                    <!-- Call To Action Buttons -->
                    <div class="pt-4 space-y-3">
                        <a href="https://line.me/ti/p/@842kcbjl" 
                           target="_blank" 
                           class="block w-full py-3.5 bg-[#00B900] text-white text-[15px] font-bold text-center rounded-xl hover:bg-[#009900] transition-colors shadow-md flex items-center justify-center gap-2">
                            <span>💬 สอบถาม / สั่งซื้อผ่าน LINE (@842kcbjl)</span>
                        </a>

                        <a href="{{ route('quotation') }}" 
                           class="block w-full py-3.5 bg-[#004998] text-white text-[15px] font-bold text-center rounded-xl hover:bg-blue-900 transition-colors shadow-md flex items-center justify-center gap-2">
                            <span>📋 ขอใบเสนอราคาออนไลน์ (Quotation)</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Re-use Recommended Products Component at bottom of Detail page -->
    <x-recommended-products />
</x-app-layout>
