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
            <div class="bg-white border border-[#E4E4E4] rounded-2xl p-6 sm:p-10 shadow-xs grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12 items-start mb-12" x-data="productCalculator({{ $product->base_price }}, {{ json_encode($product->prices->map(fn($t) => ['min_qty' => $t->min_qty, 'price' => (float)$t->price])->values()) }})">
                
                <!-- Left Column: Product Image Gallery -->
                @php
                    $allImages = $product->images->count() > 0 
                        ? $product->images->map(fn($img) => asset($img->image_path) . '?v=' . time())->toArray()
                        : [asset('images/no-image.svg')];
                @endphp
                
                <div class="space-y-4" x-data="{ 
                    images: {{ json_encode($allImages) }},
                    currentIndex: 0,
                    lightboxOpen: false,
                    get mainImage() { return this.images[this.currentIndex]; },
                    next() { this.currentIndex = (this.currentIndex + 1) % this.images.length; },
                    prev() { this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length; },
                    setIndex(idx) { this.currentIndex = idx; }
                }">
                    <!-- Main Image (Click to open Lightbox) -->
                    <div @click="lightboxOpen = true" class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-2xl p-6 border border-[#E4E4E4] flex items-center justify-center overflow-hidden relative cursor-pointer group">
                        <img :src="mainImage" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105"
                             onerror="this.src='{{ asset('images/no-image.svg') }}'" />
                             
                        <!-- Hover Overlay Icon -->
                        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <div class="bg-white/80 p-3 rounded-full shadow-sm text-gray-700">
                                <i class="fa-solid fa-expand text-xl"></i>
                            </div>
                        </div>

                        <!-- Badge Overlay -->
                        <div class="absolute top-4 left-4 flex flex-col gap-1.5 z-10">
                            @if ($product->stock_qty <= 0 && $product->type !== 'custom' && !in_array($product->category_id, [2, 5, 6, 7]) && !in_array($product->id, [10, 11, 12, 13, 14, 15, 22, 23]))
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

                    <!-- Thumbnails / Color Swatches -->
                    @if(in_array($product->id, [112, 113, 114]))
                        <!-- Glossy Carabiner Swatches -->
                        <div class="flex justify-center gap-6 py-6">
                            <a href="{{ route('products.show', 'ruby-red-112-429') }}" class="block w-8 h-8 rounded-full {{ $product->id == 112 ? 'ring-2 ring-offset-4 ring-[#004998]' : 'shadow-sm border border-gray-200 hover:scale-110 transition-transform' }}" style="background-color: #CC0000;"></a>
                            <a href="{{ route('products.show', 'black-113-683') }}" class="block w-8 h-8 rounded-full {{ $product->id == 113 ? 'ring-2 ring-offset-4 ring-[#004998]' : 'shadow-sm border border-gray-200 hover:scale-110 transition-transform' }}" style="background-color: #000000;"></a>
                            <a href="{{ route('products.show', 'silver-114-897') }}" class="block w-8 h-8 rounded-full {{ $product->id == 114 ? 'ring-2 ring-offset-4 ring-[#004998]' : 'shadow-sm border border-gray-200 hover:scale-110 transition-transform' }}" style="background-color: #A0A0A0;"></a>
                        </div>
                    @elseif(in_array($product->id, [115, 116, 117]))
                        <!-- Matte Carabiner Swatches -->
                        <div class="flex justify-center gap-6 py-6">
                            <a href="{{ route('products.show', 'silver-117-246') }}" class="block w-8 h-8 rounded-full {{ $product->id == 117 ? 'ring-2 ring-offset-4 ring-[#004998]' : 'shadow-sm border border-gray-200 hover:scale-110 transition-transform' }}" style="background-color: #A0A0A0;"></a>
                            <a href="{{ route('products.show', 'ruby-red-115-762') }}" class="block w-8 h-8 rounded-full {{ $product->id == 115 ? 'ring-2 ring-offset-4 ring-[#004998]' : 'shadow-sm border border-gray-200 hover:scale-110 transition-transform' }}" style="background-color: #CC0000;"></a>
                            <a href="{{ route('products.show', 'black-116-797') }}" class="block w-8 h-8 rounded-full {{ $product->id == 116 ? 'ring-2 ring-offset-4 ring-[#004998]' : 'shadow-sm border border-gray-200 hover:scale-110 transition-transform' }}" style="background-color: #000000;"></a>
                        </div>
                    @else
                        <!-- Standard Thumbnails -->
                        <div class="flex gap-3 overflow-x-auto w-full py-4 justify-start px-2 snap-x scrollbar-hide" style="display: flex; gap: 12px; overflow-x: auto; padding-top: 10px; padding-bottom: 10px;" x-show="images.length > 1">
                            <template x-for="(img, idx) in images" :key="idx">
                                <button @click="setIndex(idx)" 
                                        class="flex-shrink-0 rounded-xl border-2 overflow-hidden transition-all duration-200 focus:outline-none snap-center"
                                        style="width: 96px; height: 96px; min-width: 96px;"
                                        :class="currentIndex === idx ? 'border-[#004998] shadow-md scale-105' : 'border-gray-200 hover:border-[#004998]/50 hover:scale-105'">
                                    <img :src="img" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover bg-white"
                                         style="width: 100%; height: 100%; object-fit: cover;"
                                         onerror="this.src='{{ asset('images/no-image.svg') }}'">
                                </button>
                            </template>
                        </div>
                    @endif

                    <!-- Fullscreen Lightbox Modal -->
                    <template x-teleport="body">
                        <div x-show="lightboxOpen" style="display: none; z-index: 9999; background-color: rgba(0,0,0,0.95);" class="fixed inset-0 flex items-center justify-center" @keydown.window.escape="lightboxOpen = false" @keydown.window.right="if(lightboxOpen) next()" @keydown.window.left="if(lightboxOpen) prev()">
                            
                            <!-- Close Button (Top Left) -->
                            <button @click="lightboxOpen = false" class="focus:outline-none transition-colors" style="position: absolute; top: 24px; left: 24px; z-index: 50; color: white; opacity: 0.8;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>

                            <!-- Prev Button (Left) -->
                            <button @click.stop="prev()" class="bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors focus:outline-none backdrop-blur-sm" style="position: absolute; left: 24px; top: 50%; transform: translateY(-50%); width: 48px; height: 48px; z-index: 50;" x-show="images.length > 1">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>

                            <!-- Main Lightbox Image -->
                            <div class="relative w-full h-full p-12 flex items-center justify-center" @click.away="lightboxOpen = false">
                                <img :src="mainImage" 
                                     class="object-contain rounded-md shadow-2xl transition-all duration-300 bg-white"
                                     style="max-width: 90%; max-height: 85vh;"
                                     @click.stop="" />
                            </div>

                            <!-- Next Button (Right) -->
                            <button @click.stop="next()" class="bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors focus:outline-none backdrop-blur-sm" style="position: absolute; right: 24px; top: 50%; transform: translateY(-50%); width: 48px; height: 48px; z-index: 50;" x-show="images.length > 1">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <!-- Dots Pagination (Bottom Center) -->
                            <div class="flex justify-center gap-3" style="position: absolute; bottom: 32px; left: 0; right: 0; z-index: 50;" x-show="images.length > 1">
                                <template x-for="(img, idx) in images" :key="idx">
                                    <button @click.stop="setIndex(idx)" 
                                            class="w-3 h-3 rounded-full transition-all duration-200 focus:outline-none"
                                            :class="currentIndex === idx ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/70'"></button>
                                </template>
                            </div>
                        </div>
                    </template>
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
                    <div class="bg-[#F8F9FA] p-4 rounded-xl border border-[#E4E4E4]">
                        @if($product->prices->count() > 1)
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="text-[13px] text-[#686868] font-medium">ราคา:</span>
                                <span class="text-[28px] sm:text-[32px] font-extrabold text-[#004998]">
                                    ฿{{ number_format($product->prices->min('price'), 0) }} - ฿{{ number_format($product->prices->max('price'), 0) }}
                                </span>
                                <span class="text-[12px] text-gray-500">*ราคาต่อชิ้น (ตามจำนวนสั่งซื้อ)</span>
                            </div>
                            <!-- Price Tier Table -->
                            <div class="border border-[#E4E4E4] rounded-lg overflow-hidden text-center text-[13px]">
                                <div class="grid grid-cols-{{ $product->prices->count() }} bg-[#EAEAEA] font-bold text-black">
                                    @foreach($product->prices as $priceItem)
                                        <div class="p-2 border-r border-[#E4E4E4] last:border-r-0">
                                            {{ $priceItem->min_qty }}+ ชิ้น
                                        </div>
                                    @endforeach
                                </div>
                                <div class="grid grid-cols-{{ $product->prices->count() }} bg-white">
                                    @foreach($product->prices as $priceItem)
                                        <div class="p-2 border-r border-[#E4E4E4] last:border-r-0 text-[#CC0000] font-bold">
                                            ฿{{ number_format($priceItem->price, 0) }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="flex items-baseline gap-3">
                                <span class="text-[13px] text-[#686868] font-medium">ราคา:</span>
                                <span class="text-[28px] sm:text-[32px] font-extrabold text-[#004998]">
                                    ฿{{ number_format($product->prices->first()?->price ?? $product->base_price, 2) }}
                                </span>
                                <span class="text-[12px] text-gray-500">*ราคาต่อชิ้น</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Description -->
                    @if($product->type === 'ready_to_ship')
                        <!-- Ready to ship Product Details (Dynamic Specs) -->
                        <div class="space-y-1.5 text-[14px] text-gray-800">
                            @if(!empty($product->specs))
                                @foreach($product->specs as $label => $value)
                                    <p><strong>{{ $label }}:</strong> {{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                @endforeach
                            @endif
                            <p><strong>รายละเอียด:</strong> {!! nl2br(e($product->description)) !!}</p>
                            <p><strong>สินค้าในสต๊อก:</strong> {{ $product->stock_qty }}</p>
                            
                            <div class="flex flex-col gap-1.5 mt-3 text-[13px] font-bold text-black">
                                @if($product->stock_qty > 0)
                                    <a href="#" @click.prevent="showDeliveryModal = true" class="flex items-center gap-1.5 hover:text-[#CC0000] transition-colors"><i class="fa-solid fa-circle-info"></i> รายละเอียดการจัดส่ง</a>
                                @endif
                                <a href="#" @click.prevent="showReturnModal = true" class="flex items-center gap-1.5 hover:text-[#CC0000] transition-colors"><i class="fa-solid fa-circle-info"></i> รายละเอียดการเปลี่ยนคืนสินค้า</a>
                            </div>
                        </div>
                    @else
                        <!-- Product Description for other types -->
                        <div class="space-y-4">
                            @if(!empty($product->specs))
                                <div class="space-y-1.5 text-[14px] text-gray-800">
                                    @foreach($product->specs as $label => $value)
                                        <p><strong>{{ $label }}:</strong> {{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                    @endforeach
                                </div>
                            @endif

                            @if($product->type === 'custom')
                                <!-- Detailed specs for Custom Products -->
                                <div class="space-y-1.5 text-[14px] text-[#4A4A4A] leading-relaxed">
                                    <p><strong>ความยาว:</strong> 90cm</p>
                                    <p><strong>วัสดุ:</strong> ผ้าโพลีเอสเตอร์</p>
                                    <p><strong>พาร์ท/ส่วนประกอบ:</strong> ตัวล็อคแบบพิเศษพร้อมโลโก้เรซิ่น 1 จุด</p>
                                    <p><strong>ผิวสัมผัส:</strong> การถักแบบTubeler จะเรียบเนียนกว่าการถักแบบFlat</p>
                                    <p><strong>รายละเอียด:</strong> {!! nl2br(e($product->description ?? 'สายคล้องคอคุณภาพสูง')) !!}</p>
                                </div>
                            @else
                                <h3 class="text-[15px] font-bold text-black">รายละเอียดสินค้า</h3>
                                <p class="text-[14px] text-[#686868] leading-relaxed">
                                    {!! nl2br(e($product->description ?? 'สายคล้องคอและอุปกรณ์คุณภาพสูง ผลิตจากวัสดุเกรดพรีเมียม สวมใส่สบาย มีความทนทานสูง รองรับงานสกรีนลายและงานพิมพ์ฟูลคัลเลอร์')) !!}
                                </p>
                            @endif
                        </div>
                    @endif

                    <!-- Custom Specification Options Form (For Custom Products) -->
                    <!-- Removed: Options will be selected on a separate custom builder page -->

                    <!-- Quantity Counter & Calculate Box -->
                    @if($product->type === 'ready_to_ship')
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" id="detail-quantity" x-model.number="quantity" min="1" class="w-full bg-white border border-gray-300 rounded-lg p-2 text-center font-bold outline-none focus:ring-2 focus:ring-[#CC0000]">
                                <button type="button" @click="calculatePrice()" class="w-full bg-[#CC0000] hover:bg-[#A30000] text-white font-bold rounded-lg text-[15px] transition-colors shadow-sm">
                                    คำนวณราคา
                                </button>
                            </div>
                            
                            <!-- Calculation Table Result -->
                            <div x-show="showResult" x-transition.opacity class="border border-[#E4E4E4] rounded-lg overflow-hidden text-center text-[13px]" style="display: none;">
                                <div class="grid grid-cols-3 bg-[#EAEAEA] font-bold text-black p-2 border-b border-[#E4E4E4]">
                                    <div>จำนวน</div>
                                    <div>ราคาต่อหน่วย</div>
                                    <div>ราคาสุทธิ</div>
                                </div>
                                <div class="grid grid-cols-3 bg-white p-2 text-[#CC0000] font-medium">
                                    <div x-text="resultQty"></div>
                                    <div x-text="'฿' + unitPrice.toLocaleString('th-TH', {minimumFractionDigits: 2})"></div>
                                    <div x-text="'฿' + totalPrice.toLocaleString('th-TH', {minimumFractionDigits: 2})"></div>
                                </div>
                            </div>
                            <p x-show="showResult" x-transition.opacity class="text-[#CC0000] text-[12px] font-bold underline" style="display: none;">*ราคานี้ยังไม่รวม vat และค่าขนส่ง</p>
                        </div>
                    @endif

                    <!-- Call To Action Buttons -->
                    <div class="pt-2 space-y-3">
                        @if($product->type === 'custom' && !in_array($product->id, [10, 11, 12, 13, 14, 15, 22, 23]))
                            <a href="{{ route('products.customize', $product->slug) }}" class="w-full flex items-center justify-center gap-2 bg-[#004998] hover:bg-[#003366] text-white font-bold py-3.5 px-4 rounded-sm shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 border-b-4 border-[#003366]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                ออกแบบและสั่งทำสินค้านี้
                            </a>
                        @elseif(in_array($product->category_id, [2, 5, 6, 7]) || in_array($product->id, [10, 11, 12, 13, 14, 15, 22, 23]))
                            <div class="text-center py-4">
                                <p class="text-[#FF5252] text-[14px] font-bold mb-4">*** หากสนใจ กรุณาติดต่อเรา ***</p>
                                <a href="#" class="w-full py-3.5 bg-black hover:bg-gray-800 text-white text-[15px] font-bold text-center rounded-sm transition-all flex items-center justify-center gap-2 block">
                                    ติดต่อฝ่ายขาย
                                </a>
                            </div>
                        @else
                            <button type="button" 
                                    id="btn-add-to-cart"
                                    data-product-id="{{ $product->id }}"
                                    data-product-type="{{ $product->type }}"
                                    @php
                                        $readyOptions = [];
                                        if (!empty($product->specs)) {
                                            foreach($product->specs as $key => $val) {
                                                $valStr = is_array($val) ? implode(', ', $val) : $val;
                                                $readyOptions[] = $key . ' ' . $valStr;
                                            }
                                        }
                                    @endphp
                                    data-ready-options='@json($readyOptions)'
                                    class="w-full py-3.5 bg-black hover:bg-gray-800 text-white text-[15px] font-bold text-center rounded-sm transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-cart-plus text-lg"></i>
                                <span>เพิ่มลงตะกร้า</span>
                            </button>
                            <a href="{{ route('quotation') }}"
                               class="w-full py-3.5 bg-[#D9D9D9] hover:bg-[#C9C9C9] text-[#000000] text-[15px] font-bold text-center rounded-sm transition-all flex items-center justify-center gap-2 block">
                                <span>ขอใบเสนอราคา</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Delivery Modal -->
                <div x-show="showDeliveryModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                    <!-- Backdrop -->
                    <div x-show="showDeliveryModal" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="showDeliveryModal = false"></div>
                    
                    <!-- Modal Content -->
                    <div x-show="showDeliveryModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="relative bg-white w-full rounded-2xl shadow-2xl flex flex-col sm:flex-row overflow-hidden z-10"
                         style="max-width: 750px;">
                        
                        <!-- Close Button -->
                        <button @click="showDeliveryModal = false" class="absolute top-4 right-4 z-20 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <!-- Left Beautiful Graphic -->
                        <div class="relative w-full sm:w-[35%] overflow-hidden flex items-center justify-center border-b sm:border-b-0 sm:border-r border-gray-100" style="min-height: 250px; background: linear-gradient(135deg, #E3F2FD, #90CAF9);">
                            <!-- Decorative Shapes -->
                            <div class="absolute rounded-full" style="width: 12rem; height: 12rem; background-color: rgba(255,255,255,0.4); top: -4rem; left: -4rem; filter: blur(4px);"></div>
                            <div class="absolute rounded-full" style="width: 16rem; height: 16rem; background-color: rgba(25,118,210,0.1); bottom: -6rem; right: -6rem; filter: blur(12px);"></div>
                            <div class="absolute rounded-full" style="width: 6rem; height: 6rem; background-color: rgba(255,255,255,0.2); top: 50%; right: 2rem; filter: blur(4px);"></div>
                            
                            <!-- Icon Box -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="bg-white rounded-full flex items-center justify-center shadow-lg mb-4 transform transition hover:scale-105" style="width: 6rem; height: 6rem;">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#004998" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"></path>
                                        <path d="M14 9h4l4 4v5c0 .6-.4 1-1 1h-2"></path>
                                        <circle cx="7" cy="18" r="2"></circle>
                                        <circle cx="17" cy="18" r="2"></circle>
                                    </svg>
                                </div>
                                <span class="font-black uppercase shadow-sm" style="color: #004998; font-size: 15px; letter-spacing: 0.1em;">Delivery Info</span>
                            </div>
                        </div>

                        <!-- Right Content -->
                        <div class="w-full sm:w-[65%] p-8 sm:p-10 flex flex-col justify-center bg-white">
                            <h2 class="font-extrabold mb-6 pb-4" style="font-size: 1.5rem; color: #004998; border-bottom: 2px solid rgba(0, 73, 152, 0.1);">รายละเอียดการจัดส่ง</h2>
                            <ul class="space-y-4 text-[14px] text-gray-700 leading-relaxed font-medium">
                                <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                    <svg style="margin-top: 0.25rem; flex-shrink: 0;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#004998" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    <span>สินค้านี้เป็นสินค้าที่มีอยู่ในสต๊อก สามารถทำการจัดส่งได้ภายใน 24 ชม. วันทำการ(จ-ศ.)</span>
                                </li>
                                <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                    <svg style="margin-top: 0.25rem; flex-shrink: 0;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#004998" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    <span>เมื่อสั่งซื้อก่อน 12.00 น. จะทำการจัดส่งให้ภายในวันที่ทำการสั่งซื้อ หากดำเนินการสั่งซื้อหลัง 12.00 น. สินค้าจะถูกจัดส่งในวันถัดไป</span>
                                </li>
                                <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                    <svg style="margin-top: 0.25rem; flex-shrink: 0;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#004998" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    <span>ราคาค่าขนส่งจะเป็นไปตามน้ำหนัก คุณลูกค้าจะทราบราคาค่าขนส่งได้ในหน้าตะกร้าสินค้าหลังขอใบเสนอราคาเรียบร้อยแล้ว</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Return Policy Modal -->
                <div x-show="showReturnModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                    <!-- Backdrop -->
                    <div x-show="showReturnModal" x-transition.opacity class="fixed inset-0 bg-black/40 backdrop-blur-sm" @click="showReturnModal = false"></div>
                    
                    <!-- Modal Content -->
                    <div x-show="showReturnModal" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="relative bg-white w-full rounded-2xl shadow-2xl flex flex-col sm:flex-row overflow-hidden z-10"
                         style="max-width: 750px;">
                        
                        <!-- Close Button -->
                        <button @click="showReturnModal = false" class="absolute top-4 right-4 z-20 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <!-- Left Beautiful Graphic -->
                        <div class="relative w-full sm:w-[35%] overflow-hidden flex items-center justify-center border-b sm:border-b-0 sm:border-r border-gray-100" style="min-height: 250px; background: linear-gradient(135deg, #E0F7FA, #80DEEA);">
                            <!-- Decorative Shapes -->
                            <div class="absolute rounded-full" style="width: 12rem; height: 12rem; background-color: rgba(255,255,255,0.4); top: -4rem; left: -4rem; filter: blur(4px);"></div>
                            <div class="absolute rounded-full" style="width: 16rem; height: 16rem; background-color: rgba(0,131,143,0.1); bottom: -6rem; right: -6rem; filter: blur(12px);"></div>
                            
                            <!-- Icon Box -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="bg-white rounded-full flex items-center justify-center shadow-lg mb-4 transform transition hover:scale-105" style="width: 6rem; height: 6rem;">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#006064" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22v-9"></path>
                                        <path d="M15.17 2.38a2 2 0 0 0-6.34 0l-5.63 3.16a2 2 0 0 0-1.02 1.76v9.4a2 2 0 0 0 1.02 1.76l8.39 4.7a2 2 0 0 0 1.96 0l8.39-4.7a2 2 0 0 0 1.02-1.76v-9.4a2 2 0 0 0-1.02-1.76Z"></path>
                                        <path d="M2.1 7.2 12 13l9.9-5.8"></path>
                                        <path d="m12 22-4.5-2.5"></path>
                                        <path d="m17.5 13-5.5 3"></path>
                                        <path d="M12 13V6.5"></path>
                                    </svg>
                                </div>
                                <span class="font-black uppercase shadow-sm" style="color: #006064; font-size: 15px; letter-spacing: 0.1em;">Return Policy</span>
                            </div>
                        </div>

                        <!-- Right Content -->
                        <div class="w-full sm:w-[65%] p-8 sm:p-10 flex flex-col justify-center bg-white">
                            <h2 class="font-extrabold mb-6 pb-4" style="font-size: 1.5rem; color: #006064; border-bottom: 2px solid rgba(0, 96, 100, 0.1);">รายละเอียดการเปลี่ยนคืนสินค้า</h2>
                            <ul class="space-y-4 text-[14px] text-gray-700 leading-relaxed font-medium">
                                <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                                    <svg style="margin-top: 0.25rem; flex-shrink: 0;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#006064" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                    <span>เมื่อคุณลูกค้าได้รับสินค้าแล้วไม่สามารถเปลี่ยนคืนเป็นเงินสดหรือสินค้าแบบอื่นได้</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>

                <!-- Additional Custom Product Information (Block Price & Color Grid) -->
                @if($product->type === 'custom')
                    <div class="col-span-1 md:col-span-2 mt-8 border-t border-[#E4E4E4] pt-8">
                        
                        <!-- Logo Block Price Section -->
                        <div class="mb-16">
                            <p class="text-[15px] text-[#686868] mb-1">การสกรีนสายคล้องคอที่มีโลโก้ยาวๆ อาจจะทำให้ราคาบล็อกแตกต่างกัน</p>
                            <h3 class="text-[20px] font-bold text-[#004998] mb-4">ราคาค่าบล็อกตามความยาวโลโก้</h3>
                            
                            <img src="{{ asset('images/custom-block-price.png') }}" class="w-full h-auto rounded-2xl shadow-sm border border-gray-100" alt="ราคาค่าบล็อกตามความยาวโลโก้">
                        </div>

                        <!-- Rope Color Grid Section -->
                        <div class="mt-8 mb-16">
                            <h3 class="text-[20px] font-bold text-[#004998] mb-2">ตารางแสดงสีเชือก</h3>
                            <p class="text-[15px] text-[#686868] mb-4">
                                สีเชือกพื้นฐานมีให้เลือกทั้งหมด 22 สี ส่วนใหญ่นิยมสั่งซื้อโทนสีแดงและสีฟ้า ซึ่งทั้ง 2 สีมีโทนสีที่คล้ายกันคือ สีแดง (PANTONE 485C) กับ Flag red และสีน้ำเงิน (PANTONE 293C) กับ Reflex Blue และ Process Blue นอกจากนี้ยังมีสีส้มและสีดำที่เป็นที่นิยมเช่นกัน อีกทั้งยังมีสีใหม่เพิ่มเข้ามาอย่างสีชมพูและสีชมพูบานเย็นด้วย (ข้อมูลเมื่อพฤษภาคม ค.ศ. 2014)
                                <br><span class="text-[#E53935]">* หากต้องการสั่งผลิตเพิ่มอีก 1 สี จะมีค่าใช้จ่ายเพิ่มเติม 300 บาท (ไม่รวมภาษี)</span>
                            </p>
                            
                            <img src="{{ asset('images/custom-color-grid.png') }}" class="w-full h-auto rounded-lg shadow-sm border border-gray-100" alt="ตารางแสดงสีเชือก">
                        </div>

                        <!-- Usage Guide Section -->
                        <div style="margin-top: 40px;">
                            <h3 class="text-[20px] font-bold text-[#004998] mb-6">วิธีการใช้งาน</h3>
                            
                            <img src="{{ asset('images/custom-usage-guide.png') }}" class="w-[90%] md:w-[60%] lg:w-[50%] max-w-lg h-auto rounded-lg shadow-sm border border-gray-100 mx-auto block" alt="วิธีการใช้งาน">
                        </div>

                    </div>
                @endif
                
                <!-- Anti-Virus Coating Service Section -->
                @if(in_array($product->id, [1, 2, 3, 4, 5, 6, 7, 8, 10, 11, 12, 13, 14, 15]))
                    <div class="col-span-1 md:col-span-2" style="margin-top: 80px;">
                        <h3 class="text-[22px] font-bold text-center text-black" style="margin-bottom: 50px;">บริการเสริมคุณสมบัติป้องกันไวรัส</h3>
                        
                        <img src="{{ asset('images/antivirus-banner.png') }}" class="w-full max-w-4xl mx-auto h-auto rounded-lg shadow-sm" style="margin-bottom: 60px;" alt="บริการเสริมคุณสมบัติป้องกันไวรัส">
                        
                        <div class="max-w-4xl mx-auto space-y-16">
                            <div>
                                <h4 class="text-[18px] font-bold text-[#004998]" style="margin-bottom: 20px;">ข้อมูลบริการ</h4>
                                <p class="text-[15px] text-[#4A4A4A] leading-relaxed">
                                    บริการเสริมคุณสมบัติป้องกันไวรัส เป็นบริการใหม่ที่เสริมคุณสมบัติให้สายคล้องคอสามารถป้องกันและลดการเกิดไวรัส สายที่สั่งซื้อพร้อมบริการนี้จะถูกชุบด้วยน้ำยาชนิดพิเศษ ซึ่งจะมีคุณสมบัติในการทำให้ตัวผ้าและส่วนประกอบสายป้องกันการเกิดไวรัสได้ ช่วยให้ใช้งานสายได้อย่างปลอดภัยและมั่นใจมากยิ่งขึ้น
                                </p>
                            </div>
                            
                            <div style="margin-top: 30px;">
                                <h4 class="text-[18px] font-bold text-[#004998]" style="margin-bottom: 20px;">เอกสารรับรอง</h4>
                                <div class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm inline-block">
                                    <img src="{{ asset('images/antivirus-cert.png') }}" class="max-w-full md:max-w-xl h-auto" alt="เอกสารรับรองคุณสมบัติป้องกันไวรัส">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            </div>

        </div>
    </div>

    <!-- Re-use Recommended Products Component at bottom of Detail page -->
    <x-recommended-products />

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function adjustDetailQty(delta) {
        const input = document.getElementById('detail-quantity');
        if (!input) return;
        const current = parseInt(input.value) || 1;
        input.value = Math.max(1, current + delta);
    }

    // ── Add to Cart Button Handler ──
    document.getElementById('btn-add-to-cart')?.addEventListener('click', function() {
        const btn = this;
        const productId = parseInt(btn.dataset.productId);
        const productType = btn.dataset.productType;
        let readyOptions = [];
        try { readyOptions = JSON.parse(btn.dataset.readyOptions || '[]'); } catch(e) {}

        const quantity = parseInt(document.getElementById('detail-quantity')?.value) || 1;
        let options = [];

        if (productType === 'custom') {
            document.querySelectorAll('.custom-option-group').forEach(group => {
                const val = group.querySelector('.custom-option-input').value;
                if (val) {
                    options.push(val);
                }
            });
            options.push(quantity + ' ชิ้น');
        } else if (readyOptions && Array.isArray(readyOptions) && readyOptions.length > 0) {
            options = readyOptions;
        }

        function sendAddToCartRequest(confirmPreorder = false) {
            const bodyData = {
                product_id: productId,
                quantity: quantity,
                options_snapshot: options
            };
            if (confirmPreorder) {
                bodyData.confirm_preorder = true;
            }

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(bodyData)
            })
            .then(res => res.json())
            .then(res => {
                if (res.requires_preorder_confirm) {
                    Swal.fire({
                        title: 'สินค้าหมดสต็อก',
                        text: res.message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#004998',
                        cancelButtonColor: '#9CA3AF',
                        confirmButtonText: 'ยืนยันพรีออเดอร์',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            sendAddToCartRequest(true);
                        }
                    });
                } else if (res.success) {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: res.message,
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#004998',
                        cancelButtonColor: '#9CA3AF',
                        confirmButtonText: 'ไปยังตะกร้าสินค้า',
                        cancelButtonText: 'เลือกซื้อต่อ'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("cart.index") }}';
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    Swal.fire('เกิดข้อผิดพลาด', res.message || 'ไม่สามารถเพิ่มสินค้าลงตะกร้าได้', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อระบบได้', 'error');
            });
        }

        sendAddToCartRequest(false);
    });

    document.addEventListener('alpine:init', () => {
        Alpine.data('productCalculator', (basePrice, priceTiers = []) => ({
            quantity: 1,
            unitPrice: basePrice,
            showResult: false,
            resultQty: 1,
            totalPrice: basePrice,
            showDeliveryModal: false,
            showReturnModal: false,
            priceTiers: priceTiers,
            
            calculatePrice() {
                if (this.quantity < 1) this.quantity = 1;
                this.resultQty = this.quantity;
                
                // คำนวณราคาจาก price tiers
                if (this.priceTiers.length > 0) {
                    let matched = null;
                    // เรียงจาก min_qty มากไปน้อย แล้วหาตัวแรกที่ <= quantity
                    const sorted = [...this.priceTiers].sort((a, b) => b.min_qty - a.min_qty);
                    for (const tier of sorted) {
                        if (this.quantity >= tier.min_qty) {
                            matched = tier;
                            break;
                        }
                    }
                    this.unitPrice = matched ? matched.price : basePrice;
                } else {
                    this.unitPrice = basePrice;
                }
                
                this.totalPrice = this.quantity * this.unitPrice;
                this.showResult = true;
            }
        }))
    })
    </script>
    @endpush

</x-app-layout>
