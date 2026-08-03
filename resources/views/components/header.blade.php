<header x-data="{ mobileMenuOpen: false, openDropdown: null }" class="w-full sticky top-0 z-40 shadow-sm border-b border-[#E4E4E4]">
    <!-- Main Navigation Bar (Bg: #122244, Dimension: 1280 * 101) -->
    <div class="bg-[#122244] text-white h-[101px] flex items-center justify-center px-4 md:px-6">
        <div class="w-full max-w-[1280px] h-full mx-auto flex items-center justify-between">
            <!-- Far Left: Logo (Size 134 * 50) -->
            <a href="/" class="flex items-center group shrink-0">
                <img src="{{ asset('images/logo-header.png') }}" alt="HOT STRAP Logo" class="w-[134px] h-[50px] object-contain group-hover:opacity-95 transition-opacity" />
            </a>

            <!-- Desktop Navigation Links (Font size 18px, Spacing between menus: 1cm) -->
            <nav class="hidden lg:flex items-center space-x-6 xl:space-x-[1cm] text-[18px] font-medium">
                <!-- 1. สินค้าทั้งหมด (ภาพที่ 1: ไอคอนสายคล้อง) -->
                <a href="{{ route('products.index') }}" class="inline-flex items-center hover:text-blue-200 transition-colors py-2">
                    <img src="{{ asset('images/icons/icon-all-products.png') }}" class="w-5 h-10 mr-2 object-contain brightness-0 invert" alt="" />
                    <span>สินค้าทั้งหมด</span>
                </a>

                <!-- 2. สินค้าอื่น ๆ (ภาพที่ 2: ไอคอนซอง/บัตรพนักงาน) -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="inline-flex items-center hover:text-blue-200 transition-colors py-2 focus:outline-none">
                        <img src="{{ asset('images/icons/icon-other-products.png') }}" class="w-5 h-15 mr-2 object-contain brightness-0 invert" alt="" />
                        <span>สินค้าอื่น ๆ</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 mt-1 w-60 bg-white text-[#000000] text-[16px] rounded-lg shadow-xl py-2 z-50 border border-[#E4E4E4]"
                         style="display: none;">
                        <a href="{{ route('products.index', ['category_slugs' => ['badge-holders']]) }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">กรอบ/ซองใส่บัตร</a>
                        <a href="{{ route('products.index', ['category_slugs' => ['yoyo-badge-holders']]) }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">โยโย่ห้อยบัตร</a>
                        <a href="{{ route('products.index', ['category_slugs' => ['lanyard-parts']]) }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">พาร์ทสายคล้องคอ</a>
                        <a href="{{ route('products.index', ['category_slugs' => ['carabiners']]) }}" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">คาราบิเนอร์</a>
                        <a href="https://hotmobilythai.com/" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between px-4 py-2.5 text-[#004998] font-semibold hover:bg-blue-50 transition-colors border-t border-gray-100 mt-1">
                            <span>ผลิตภัณฑ์อะคริลิค</span>
                            <svg class="w-4 h-4 text-[#004998] ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

                <!-- 3. รายละเอียดสินค้าเพิ่มเติม (ภาพที่ 3: ไอคอนวงกลม 3 จุด) -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="inline-flex items-center hover:text-blue-200 transition-colors py-2 focus:outline-none">
                        <img src="{{ asset('images/icons/icon-details.png') }}" class="w-5 h-5 mr-2 object-contain brightness-0 invert" alt="" />
                        <span>รายละเอียดสินค้าเพิ่มเติม</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 mt-1 w-64 bg-white text-[#000000] text-[16px] rounded-lg shadow-xl py-2 z-50 border border-[#E4E4E4]"
                         style="display: none;">
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">ลักษณะผ้า</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">สีเชือก</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">บริการต้านไวรัส</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">วิธีสั่งซื้อ</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">การจัดส่ง</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">FAQ</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">วิธีการออกแบบ</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">วิธีชำระเงิน</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">วิธียกเลิกคำสั่งซื้อ</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">แกลลอรี่</a>
                    </div>
                </div>

                <!-- 4. ติดต่อเรา -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button @click="open = !open" class="inline-flex items-center hover:text-blue-200 transition-colors py-2 focus:outline-none">
                        <svg class="w-6 h-6 mr-1.5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span>ติดต่อเรา</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute left-0 mt-1 w-52 bg-white text-[#000000] text-[16px] rounded-lg shadow-xl py-2 z-50 border border-[#E4E4E4]"
                         style="display: none;">
                        <a href="/contact" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">ติดต่อเรา</a>
                        <a href="#" class="block px-4 py-2.5 hover:bg-blue-50 hover:text-[#122244] transition-colors">แจ้งชำระเงิน</a>
                    </div>
                </div>
            </nav>

            <!-- Right Actions (Cart Icon ภาพที่ 5) -->
            <div class="flex items-center space-x-3">
                @php
                    $cartCount = 0;
                    $sessionId = request()->cookie('cart_session_id');
                    $cartObj = \App\Models\Cart::where('session_id', $sessionId)->first();
                    if ($cartObj) {
                        $cartCount = $cartObj->items()->sum('quantity');
                    }
                @endphp
                <a href="{{ route('cart.index') }}" class="relative p-2 text-white hover:text-blue-200 transition-colors focus:outline-none" title="ตะกร้าสินค้า">
                    <img src="{{ asset('images/icons/icon-cart.png') }}" class="w-7 h-7 object-contain brightness-0 invert" alt="ตะกร้าสินค้า" />
                    <!-- Cart Item Count Badge (#F21515) -->
                    @if($cartCount > 0)
                    <span id="headerCartBadge" class="absolute top-0 right-0 bg-[#F21515] text-white font-bold text-xs w-5 h-5 rounded-full flex items-center justify-center border-2 border-[#122244] shadow-xs transform translate-x-1 -translate-y-1">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>

                <!-- Mobile Hamburger Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="lg:hidden p-2 text-white hover:text-blue-200 focus:outline-none focus:ring-2 focus:ring-white rounded-full transition-transform duration-200"
                        aria-label="Toggle Menu">
                    <template x-if="!mobileMenuOpen">
                        <div class="w-8 h-8 rounded-full border-2 border-white/60 flex items-center justify-center p-1.5">
                            <div class="w-full flex flex-col space-y-1">
                                <span class="w-full h-0.5 bg-white rounded-full"></span>
                                <span class="w-full h-0.5 bg-white rounded-full"></span>
                                <span class="w-full h-0.5 bg-white rounded-full"></span>
                            </div>
                        </div>
                    </template>
                    <template x-if="mobileMenuOpen">
                        <div class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-5 h-5 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </template>
                </button>
            </div>
        </div>
    </div>

    <!-- Contact Info Sub-Bar (White Background - Hidden on small mobile screens < 640px, Shown on sm:block) -->
    <div class="bg-white text-gray-800 text-[12px] py-2.5 px-3 border-b border-[#E4E4E4] hidden sm:block">
        <div class="max-w-[1280px] mx-auto flex items-center justify-between gap-3 text-[12px] flex-nowrap">
            <!-- 1. Address -->
            <a href="https://maps.google.com" target="_blank" class="inline-flex items-center text-[#5B5B5B] hover:text-[#122244] transition-colors shrink-0">
                <svg class="w-4 h-4 mr-1.5 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>23/34-35 อาคารโครงการเดอะไพร์ม หัวลำโพง</span>
            </a>

            <!-- 2. Sales Phone -->
            <div class="inline-flex items-center text-[#5B5B5B] shrink-0">
                <svg class="w-4 h-4 mr-1.5 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span><strong>ฝ่ายขาย :</strong> 064-604-5614 , 02-637-8997 / 8995</span>
            </div>

            <!-- 3. Email -->
            <a href="mailto:sales.ye@youandearth-th.com" class="inline-flex items-center text-[#5B5B5B] hover:text-[#122244] transition-colors shrink-0">
                <svg class="w-7 h-7 mr-1.5 text-[#000000]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                </svg>
                <span>sales.ye@youandearth-th.com</span>
            </a>

            <!-- 4. Line ID -->
            <a href="https://line.me/ti/p/@842kcbjl" target="_blank" class="inline-flex items-center text-[#5B5B5B] hover:text-green-600 font-medium shrink-0">
                <img src="{{ asset('images/icons/icon-line.png') }}" class="w-4 h-4 mr-1.5 object-contain" alt="LINE" />
                <span>Line id: @842kcbjl</span>
            </a>

            <!-- 5. Social Icons (Facebook & X) -->
            <div class="flex items-center space-x-3 shrink-0">
                <a href="#" class="text-[#000000] hover:text-blue-600 transition-colors" title="Facebook">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="text-[#000000] hover:text-gray-600 transition-colors" title="X (Twitter)">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
            </div>
        </div>
    </div>



    <!-- Mobile Full Screen Navigation Overlay Drawer -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="fixed inset-0 top-[60px] bg-[#122244] text-white z-50 overflow-y-auto lg:hidden p-6 flex flex-col justify-between"
         style="display: none;">
        
        <div class="space-y-6">
            <div class="pb-4 border-b border-white/20 flex items-center justify-between">
                <span class="text-base font-semibold tracking-wider text-blue-200 uppercase">เมนูเว็บไซต์</span>
                <button @click="mobileMenuOpen = false" class="text-white text-xs bg-white/10 px-3 py-1 rounded-full flex items-center">
                    <span>ปิด</span>
                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="space-y-3">
                <a href="{{ route('products.index') }}" class="block text-lg font-medium py-2 px-3 rounded-lg hover:bg-white/10 transition-colors">
                    สินค้าทั้งหมด
                </a>

                <div x-data="{ open: false }" class="border-b border-white/10 pb-2">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-lg font-medium py-2 px-3 rounded-lg hover:bg-white/10 transition-colors">
                        <span>สินค้าอื่น ๆ</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-6 pt-2 space-y-2 text-base text-blue-100">
                        <a href="{{ route('products.index', ['category_slugs' => ['badge-holders']]) }}" class="block py-1 hover:text-white">กรอบ/ซองใส่บัตร</a>
                        <a href="{{ route('products.index', ['category_slugs' => ['yoyo-badge-holders']]) }}" class="block py-1 hover:text-white">โยโย่ห้อยบัตร</a>
                        <a href="{{ route('products.index', ['category_slugs' => ['lanyard-parts']]) }}" class="block py-1 hover:text-white">พาร์ทสายคล้องคอ</a>
                        <a href="{{ route('products.index', ['category_slugs' => ['carabiners']]) }}" class="block py-1 hover:text-white">คาราบิเนอร์</a>
                        <a href="https://hotmobilythai.com/" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between py-1 text-yellow-300 font-semibold hover:text-white border-t border-white/10 pt-2 mt-1">
                            <span>ผลิตภัณฑ์อะคริลิค</span>
                            <svg class="w-4 h-4 text-yellow-300 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-white/10 pb-2">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-lg font-medium py-2 px-3 rounded-lg hover:bg-white/10 transition-colors">
                        <span>รายละเอียดสินค้าเพิ่มเติม</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-6 pt-2 space-y-2 text-base text-blue-100">
                        <a href="#" class="block py-1 hover:text-white">ลักษณะผ้า</a>
                        <a href="#" class="block py-1 hover:text-white">สีเชือก</a>
                        <a href="#" class="block py-1 hover:text-white">บริการต้านไวรัส</a>
                        <a href="#" class="block py-1 hover:text-white">วิธีสั่งซื้อ</a>
                        <a href="#" class="block py-1 hover:text-white">การจัดส่ง</a>
                        <a href="#" class="block py-1 hover:text-white">FAQ</a>
                        <a href="#" class="block py-1 hover:text-white">วิธีการออกแบบ</a>
                        <a href="#" class="block py-1 hover:text-white">วิธีชำระเงิน</a>
                        <a href="#" class="block py-1 hover:text-white">วิธียกเลิกคำสั่งซื้อ</a>
                        <a href="#" class="block py-1 hover:text-white">แกลลอรี่</a>
                    </div>
                </div>

                <div x-data="{ open: false }" class="border-b border-white/10 pb-2">
                    <button @click="open = !open" class="w-full flex items-center justify-between text-lg font-medium py-2 px-3 rounded-lg hover:bg-white/10 transition-colors">
                        <span>ติดต่อเรา</span>
                        <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-6 pt-2 space-y-2 text-base text-blue-100">
                        <a href="/contact" class="block py-1 hover:text-white">ติดต่อเรา</a>
                        <a href="#" class="block py-1 hover:text-white">แจ้งชำระเงิน</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-white/20 text-xs text-blue-200 space-y-2">
            <p><strong>ฝ่ายขาย :</strong> 064-604-5614 , 02-637-8997</p>
            <p><strong>Line ID :</strong> @842kcbjl</p>
        </div>
    </div>
</header>
