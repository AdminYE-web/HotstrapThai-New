<x-app-layout>
    <x-slot name="title">HOT STRAP - หน้าหลัก ผลิตสายคล้องคอ & ซองใส่บัตรพนักงาน</x-slot>

    <!-- SECTION 1: ภาพแบนเนอร์หลัก (Main Hero Banner - Desktop & Mobile Responsive) -->
    <section class="w-full mx-auto bg-[#F3F3F3]">
        <a href="https://line.me/ti/p/@842kcbjl" target="_blank" class="block group">
            <!-- Desktop Hero Banner -->
            <img src="{{ asset('images/hero-banner.png') }}?v={{ time() }}" 
                 alt="HOT STRAP Main Hero Banner" 
                 class="hidden sm:block w-full h-auto object-cover group-hover:opacity-95 transition-opacity" />
            <!-- Mobile Hero Banner -->
            <img src="{{ asset('images/hero-banner-mobile.png') }}?v={{ time() }}" 
                 alt="HOT STRAP Main Hero Banner Mobile" 
                 class="block sm:hidden w-full h-auto object-cover group-hover:opacity-95 transition-opacity" />
        </a>
    </section>

    <!-- ================= 3.1 HOME PAGE (REMAINING SECTIONS) ================= -->
    <div class="bg-white">

        <!-- SECTION 2: สินค้าแนะนำ (1 แถว 4 การ์ด - Equal Frame Aspect Ratio 4:3, Bg: #F8F8F8) -->
        <section class="bg-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-[24px] font-bold text-[#000000] mb-8">
                    สินค้าแนะนำ
                </h2>

                <!-- Desktop/Laptop/PC: Fixed 4 Cards Grid (sm:grid-cols-4) | Mobile: Horizontal Swipe Slider -->
                <div class="flex sm:grid sm:grid-cols-4 gap-4 sm:gap-6 overflow-x-auto sm:overflow-x-visible snap-x snap-mandatory pb-4 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-none">
                    <!-- Card 1 -->
                    <a href="/products/prod-1-1-123" class="w-[220px] sm:w-full shrink-0 sm:shrink snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 transition-colors">
                                <img src="{{ asset('images/products/lanyard-premium.png') }}" alt="สายคล้องคอแบบพรีเมี่ยม" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอแบบพรีเมี่ยม</h3>
                        </div>
                    </a>

                    <!-- Card 2 -->
                    <a href="/products/prod-2-2-180" class="w-[220px] sm:w-full shrink-0 sm:shrink snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 transition-colors">
                                <img src="{{ asset('images/products/lanyard-polyester.png') }}" alt="สายคล้องคอผ้าโพลีเอสเตอร์ (สกรีนลาย)" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอผ้าโพลีเอสเตอร์<br><span class="text-[13px]">(สกรีนลาย)</span></h3>
                        </div>
                    </a>

                    <!-- Card 3 -->
                    <a href="/products/prod-3-3-702" class="w-[220px] sm:w-full shrink-0 sm:shrink snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 transition-colors">
                                <img src="{{ asset('images/products/lanyard-nylon.png') }}" alt="สายคล้องคอผ้าไนลอน" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอผ้าไนลอน</h3>
                        </div>
                    </a>

                    <!-- Card 4 -->
                    <a href="/products/prod-4-4-701" class="w-[220px] sm:w-full shrink-0 sm:shrink snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 transition-colors">
                                <img src="{{ asset('images/products/lanyard-sublimation.png') }}" alt="สายคล้องคอสกรีนซับลิเมชั่น" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-200" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอสกรีนซับลิเมชั่น</h3>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- SECTION 3: เกี่ยวกับเรา (Custom About Section Component) -->
        <section id="about" class="bg-white pb-6">
            <x-about-section />
        </section>

        <!-- SECTION 4: สินค้าอื่นๆ (Desktop: 3 Slides x 4 Cards | Mobile: Horizontal Swipe Slider) -->
        <section id="all-products" class="bg-white py-10" x-data="{ activeSlide: 0, maxSlides: 3 }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Title & Prev/Next Controls -->
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-[24px] font-bold text-[#000000]">สินค้าอื่นๆ</h2>
                    
                    <!-- Circular Prev / Next Slider Buttons (Desktop Only) -->
                    <div class="hidden sm:flex items-center space-x-2">
                        <button @click="activeSlide = Math.max(0, activeSlide - 1)" 
                                :disabled="activeSlide === 0" 
                                :class="activeSlide === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-gray-100'"
                                aria-label="Previous slide"
                                class="w-9 h-9 rounded-full border border-[#E4E4E4] flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="activeSlide = Math.min(maxSlides - 1, activeSlide + 1)" 
                                :disabled="activeSlide === maxSlides - 1" 
                                :class="activeSlide === maxSlides - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-gray-100'"
                                aria-label="Next slide"
                                class="w-9 h-9 rounded-full border border-[#E4E4E4] flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Desktop 3 Slides Container (Hidden on Mobile) -->
                <div class="hidden sm:block overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${activeSlide * 100}%)`">
                        
                        <!-- SLIDE 1 (4 Cards from user images) -->
                        <div class="w-full shrink-0 grid grid-cols-2 lg:grid-cols-4 gap-5">
                            <!-- Card 1 -->
                            <a href="/products/prod-9-9-296" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-snap-yoyo.png') }}" alt="สายคล้องคอ Snap yoyo" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอ Snap yoyo</h3>
                                </div>
                            </a>

                            <!-- Card 2 -->
                            <a href="/products/prod-12-12-652" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-resin-logo.png') }}" alt="สายคล้องคอติดโลโก้เรซิ่น" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอติดโลโก้เรซิ่น</h3>
                                </div>
                            </a>

                            <!-- Card 3 -->
                            <a href="/products/prod-6-6-662" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-antibacterial.png') }}" alt="สายคล้องคอต้านเชื้อแบคทีเรีย" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอต้านเชื้อแบคทีเรีย</h3>
                                </div>
                            </a>

                            <!-- Card 4 -->
                            <a href="/products/prod-7-7-536" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-jacquard.png') }}" alt="สายคล้องคอผ้าแจ็คการ์ด" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอผ้าแจ็คการ์ด</h3>
                                </div>
                            </a>
                        </div>

                        <!-- SLIDE 2 (4 Cards from new user images) -->
                        <div class="w-full shrink-0 grid grid-cols-2 lg:grid-cols-4 gap-5">
                            <!-- Card 5: สายคล้องคอซิลิโคน (สกรีนลาย) -->
                            <a href="{{ route('products.index') }}" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-silicone.png') }}" alt="สายคล้องคอซิลิโคน (สกรีนลาย)" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอซิลิโคน (สกรีนลาย)</h3>
                                </div>
                            </a>

                            <!-- Card 6: สายคล้องคอแบบชุดสำเร็จรูป -->
                            <a href="/products/prod-8-8-812" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-set-ready.png') }}" alt="สายคล้องคอแบบชุดสำเร็จรูป" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอแบบชุดสำเร็จรูป</h3>
                                </div>
                            </a>

                            <!-- Card 7: สายคล้องบัตรรีไซเคิล -->
                            <a href="/products/prod-5-5-937" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-recycle.png') }}" alt="สายคล้องบัตรรีไซเคิล" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องบัตรรีไซเคิล</h3>
                                </div>
                            </a>

                            <!-- Card 8: สายคล้องบัตรสะท้อนแสง -->
                            <a href="{{ route('products.index') }}" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-reflective.png') }}" alt="สายคล้องบัตรสะท้อนแสง" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องบัตรสะท้อนแสง</h3>
                                </div>
                            </a>
                        </div>

                        <!-- SLIDE 3 (4 Cards from new user images) -->
                        <div class="w-full shrink-0 grid grid-cols-2 lg:grid-cols-4 gap-5">
                            <!-- Card 9: สายคล้องบัตรหนัง PU -->
                            <a href="{{ route('products.index') }}" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-safety-lock.png') }}" alt="สายคล้องบัตรหนัง PU" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องบัตรหนัง PU</h3>
                                </div>
                            </a>

                            <!-- Card 10: สายคล้องเหรียญรางวัลอะคริลิค -->
                            <a href="{{ route('products.index') }}" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/lanyard-fancy-pendant.png') }}" alt="สายคล้องเหรียญรางวัลอะคริลิค" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องเหรียญรางวัลอะคริลิค</h3>
                                </div>
                            </a>

                            <!-- Card 11: สายคล้องโทรศัพท์ -->
                            <a href="{{ route('products.index') }}" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/phone-strap.png') }}" alt="สายคล้องโทรศัพท์" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องโทรศัพท์</h3>
                                </div>
                            </a>

                            <!-- Card 12: สายคล้องข้อมือ -->
                            <a href="{{ route('products.index') }}" class="group text-center flex flex-col justify-between cursor-pointer">
                                <div>
                                    <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                        <img src="{{ asset('images/products/wristband-event.png') }}" alt="สายคล้องข้อมือ" class="w-full h-full object-contain product-card-zoom group-hover:scale-110 group-active:scale-110 transition-transform duration-300 ease-out" />
                                    </div>
                                    <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องข้อมือ</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Horizontal Swipe Slider (Visible only on mobile < sm - Same size as Section 2) -->
                <div class="flex sm:hidden overflow-x-auto snap-x snap-mandatory gap-4 pb-4 -mx-4 px-4 scrollbar-none">
                    <!-- Card 1 -->
                    <a href="/products/prod-9-9-296" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-snap-yoyo.png') }}" alt="สายคล้องคอ Snap yoyo" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอ Snap yoyo</h3>
                        </div>
                    </a>
                    <!-- Card 2 -->
                    <a href="/products/prod-12-12-652" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-resin-logo.png') }}" alt="สายคล้องคอติดโลโก้เรซิ่น" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอติดโลโก้เรซิ่น</h3>
                        </div>
                    </a>
                    <!-- Card 3 -->
                    <a href="/products/prod-6-6-662" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-antibacterial.png') }}" alt="สายคล้องคอต้านเชื้อแบคทีเรีย" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอต้านเชื้อแบคทีเรีย</h3>
                        </div>
                    </a>
                    <!-- Card 4 -->
                    <a href="/products/prod-7-7-536" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-jacquard.png') }}" alt="สายคล้องคอผ้าแจ็คการ์ด" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอผ้าแจ็คการ์ด</h3>
                        </div>
                    </a>
                    <!-- Card 5 -->
                    <a href="{{ route('products.index') }}" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-silicone.png') }}" alt="สายคล้องคอซิลิโคน (สกรีนลาย)" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอซิลิโคน (สกรีนลาย)</h3>
                        </div>
                    </a>
                    <!-- Card 6 -->
                    <a href="/products/prod-8-8-812" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-set-ready.png') }}" alt="สายคล้องคอแบบชุดสำเร็จรูป" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องคอแบบชุดสำเร็จรูป</h3>
                        </div>
                    </a>
                    <!-- Card 7 -->
                    <a href="/products/prod-5-5-937" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-recycle.png') }}" alt="สายคล้องบัตรรีไซเคิล" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องบัตรรีไซเคิล</h3>
                        </div>
                    </a>
                    <!-- Card 8 -->
                    <a href="{{ route('products.index') }}" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-reflective.png') }}" alt="สายคล้องบัตรสะท้อนแสง" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องบัตรสะท้อนแสง</h3>
                        </div>
                    </a>
                    <!-- Card 9 -->
                    <a href="{{ route('products.index') }}" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-safety-lock.png') }}" alt="สายคล้องบัตรหนัง PU" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องบัตรหนัง PU</h3>
                        </div>
                    </a>
                    <!-- Card 10 -->
                    <a href="{{ route('products.index') }}" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/lanyard-fancy-pendant.png') }}" alt="สายคล้องเหรียญรางวัลอะคริลิค" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องเหรียญรางวัลอะคริลิค</h3>
                        </div>
                    </a>
                    <!-- Card 11 -->
                    <a href="{{ route('products.index') }}" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/phone-strap.png') }}" alt="สายคล้องโทรศัพท์" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องโทรศัพท์</h3>
                        </div>
                    </a>
                    <!-- Card 12 -->
                    <a href="{{ route('products.index') }}" class="w-[220px] shrink-0 snap-start group text-center block flex flex-col justify-between">
                        <div>
                            <div class="bg-[#F8F8F8] w-full aspect-[4/3] rounded-xl flex items-center justify-center mb-4 p-4 overflow-hidden transition-colors">
                                <img src="{{ asset('images/products/wristband-event.png') }}" alt="สายคล้องข้อมือ" class="w-full h-full object-contain product-card-zoom group-hover:scale-110" />
                            </div>
                            <h3 class="text-[14px] font-medium text-[#000000] leading-snug">สายคล้องข้อมือ</h3>
                        </div>
                    </a>
                </div>

                <!-- Bottom Center Capsule / Pill CTA Button -->
                <div class="mt-10 flex justify-center">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center bg-[#F3F3F3] p-1.5 rounded-full hover:bg-gray-200 transition-colors group">
                        <span class="bg-white text-black text-[14px] font-bold px-6 py-2 rounded-full shadow-xs group-hover:bg-gray-50 transition-colors">
                            ดูทั้งหมด
                        </span>
                        <span class="px-4 text-black font-bold text-lg group-hover:translate-x-1 transition-transform">
                            &rarr;
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- SECTION 5: อุปกรณ์เสริม (Desktop: 2 Rows x 2 Cards | Mobile: 1 Card per Row, Equal Height) -->
        <section id="accessories" class="w-full bg-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-[24px] font-bold text-[#000000] mb-8 text-left">อุปกรณ์เสริม</h2>
                
                <!-- Desktop Layout (Hidden on mobile < sm) -->
                <div class="hidden sm:flex flex-col gap-3.5 w-full">
                    <!-- Row 1: Top Cards (60% : 40%) -->
                    <div style="display: flex; flex-direction: row; gap: 14px; width: 100%;">
                        <!-- Card 1: กรอบ/ซองใส่บัตรพนักงาน (60%) -->
                        <a href="/products?category_slugs[]=badge-holders" class="group border border-[#E4E4E4] rounded-xl sm:rounded-2xl bg-white relative overflow-hidden transition-all duration-300 h-[150px] md:h-[160px] flex items-center justify-center cursor-pointer shrink-0" style="flex: 0 0 calc(60% - 7px); width: calc(60% - 7px);">
                            <div class="w-full h-full flex items-center justify-center p-2.5 sm:p-3 overflow-hidden">
                                <img src="{{ asset('images/products/acc-badge-holder.png') }}?v={{ time() }}" alt="กรอบ/ซองใส่บัตรพนักงาน" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                            </div>
                            <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                                <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] sm:text-[14px] font-medium px-6 sm:px-8 py-3 rounded-none text-center">
                                    กรอบ/ซองใส่บัตรพนักงาน
                                </span>
                            </div>
                        </a>

                        <!-- Card 2: โยโย่ห้อยบัตร (40%) -->
                        <a href="/products?category_slugs[]=yoyo-badge-holders" class="group border border-[#E4E4E4] rounded-xl sm:rounded-2xl bg-white relative overflow-hidden transition-all duration-300 h-[150px] md:h-[160px] flex items-center justify-center cursor-pointer shrink-0" style="flex: 0 0 calc(40% - 7px); width: calc(40% - 7px);">
                            <div class="w-full h-full flex items-center justify-center p-2.5 sm:p-3 overflow-hidden">
                                <img src="{{ asset('images/products/acc-yoyo.png') }}?v={{ time() }}" alt="โยโย่ห้อยบัตร" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                            </div>
                            <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                                <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] sm:text-[14px] font-medium px-6 sm:px-8 py-3 rounded-none text-center">
                                    โยโย่ห้อยบัตร
                                </span>
                            </div>
                        </a>
                    </div>

                    <!-- Row 2: Bottom Cards (40% : 60%) -->
                    <div style="display: flex; flex-direction: row; gap: 14px; width: 100%;">
                        <!-- Card 3: คาราบิเนอร์ (40%) -->
                        <a href="/products?category_slugs[]=carabiners" class="group border border-[#E4E4E4] rounded-xl sm:rounded-2xl bg-white relative overflow-hidden transition-all duration-300 h-[150px] md:h-[160px] flex items-center justify-center cursor-pointer shrink-0" style="flex: 0 0 calc(40% - 7px); width: calc(40% - 7px);">
                            <div class="w-full h-full flex items-center justify-center p-2.5 sm:p-3 overflow-hidden">
                                <img src="{{ asset('images/products/acc-carabiner.png') }}?v={{ time() }}" alt="คาราบิเนอร์" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                            </div>
                            <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                                <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] sm:text-[14px] font-medium px-6 sm:px-8 py-3 rounded-none text-center">
                                    คาราบิเนอร์
                                </span>
                            </div>
                        </a>

                        <!-- Card 4: พาร์ทสายคล้องคอ (60%) -->
                        <a href="/products?category_slugs[]=lanyard-parts" class="group border border-[#E4E4E4] rounded-xl sm:rounded-2xl bg-white relative overflow-hidden transition-all duration-300 h-[150px] md:h-[160px] flex items-center justify-center cursor-pointer shrink-0" style="flex: 0 0 calc(60% - 7px); width: calc(60% - 7px);">
                            <div class="w-full h-full flex items-center justify-end overflow-hidden">
                                <img src="{{ asset('images/products/acc-parts.png') }}?v={{ time() }}" alt="พาร์ทสายคล้องคอ" class="w-full h-full object-cover object-right product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                            </div>
                            <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                                <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] sm:text-[14px] font-medium px-6 sm:px-8 py-3 rounded-none text-center">
                                    พาร์ทสายคล้องคอ
                                </span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Mobile Layout (Visible only on mobile < sm: 1 card per row, forced 100% equal height & width) -->
                <div class="flex sm:hidden flex-col gap-3.5 w-full">
                    <!-- Card 1 -->
                    <a href="/products?category_slugs[]=badge-holders" class="group border border-[#E4E4E4] rounded-xl bg-white relative overflow-hidden transition-all duration-300 flex items-center justify-center cursor-pointer" style="width: 100%; height: 185px; position: relative;">
                        <div class="w-full h-full flex items-center justify-center p-3 sm:p-4 overflow-hidden">
                            <img src="{{ asset('images/products/acc-badge-holder.png') }}?v={{ time() }}" alt="กรอบ/ซองใส่บัตรพนักงาน" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                        </div>
                        <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                            <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] font-medium px-5 py-2.5 rounded-none text-center">
                                กรอบ/ซองใส่บัตรพนักงาน
                            </span>
                        </div>
                    </a>

                    <!-- Card 2 -->
                    <a href="/products?category_slugs[]=yoyo-badge-holders" class="group border border-[#E4E4E4] rounded-xl bg-white relative overflow-hidden transition-all duration-300 flex items-center justify-center cursor-pointer" style="width: 100%; height: 185px; position: relative;">
                        <div class="w-full h-full flex items-center justify-center p-3 sm:p-4 overflow-hidden">
                            <img src="{{ asset('images/products/acc-yoyo.png') }}?v={{ time() }}" alt="โยโย่ห้อยบัตร" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                        </div>
                        <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                            <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] font-medium px-5 py-2.5 rounded-none text-center">
                                โยโย่ห้อยบัตร
                            </span>
                        </div>
                    </a>

                    <!-- Card 3 -->
                    <a href="/products?category_slugs[]=carabiners" class="group border border-[#E4E4E4] rounded-xl bg-white relative overflow-hidden transition-all duration-300 flex items-center justify-center cursor-pointer" style="width: 100%; height: 185px; position: relative;">
                        <div class="w-full h-full flex items-center justify-center p-3 sm:p-4 overflow-hidden">
                            <img src="{{ asset('images/products/acc-carabiner.png') }}?v={{ time() }}" alt="คาราบิเนอร์" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                        </div>
                        <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                            <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] font-medium px-5 py-2.5 rounded-none text-center">
                                คาราบิเนอร์
                            </span>
                        </div>
                    </a>

                    <!-- Card 4 -->
                    <a href="/products?category_slugs[]=lanyard-parts" class="group border border-[#E4E4E4] rounded-xl bg-white relative overflow-hidden transition-all duration-300 flex items-center justify-center cursor-pointer" style="width: 100%; height: 185px; position: relative;">
                        <div class="w-full h-full flex items-center justify-center p-3 sm:p-4 overflow-hidden">
                            <img src="{{ asset('images/products/acc-parts.png') }}?v={{ time() }}" alt="พาร์ทสายคล้องคอ" class="w-full h-full object-contain product-card-zoom group-hover:scale-105 group-active:scale-105 transition-transform duration-300 ease-out" />
                        </div>
                        <div style="position: absolute; bottom: 12px; left: 12px; z-index: 10; pointer-events: none;">
                            <span class="inline-block bg-[#F3F3F3] text-[#000000] text-[13px] font-medium px-5 py-2.5 rounded-none text-center">
                                พาร์ทสายคล้องคอ
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- SECTION 6: ภาพคั่นกลาง (Intermediate Banner - Desktop & Mobile Responsive) -->
        <section class="w-full mx-auto">
            <a href="https://line.me/ti/p/@842kcbjl" target="_blank" class="block group">
                <!-- Desktop Line Banner -->
                <img src="{{ asset('images/line-banner.png') }}?v={{ time() }}" 
                     alt="Line Official Account @842kcbjl" 
                     class="hidden sm:block w-full h-auto object-cover group-hover:opacity-95 transition-opacity" />
                <!-- Mobile Line Banner -->
                <img src="{{ asset('images/line-banner-mobile.png') }}?v={{ time() }}" 
                     alt="Line Official Account @842kcbjl Mobile" 
                     class="block sm:hidden w-full h-auto object-cover group-hover:opacity-95 transition-opacity" />
            </a>
        </section>

        <!-- SECTION 7: สายคล้องคอตามโอกาสการใช้งาน (Desktop Grid 3 Cards | Mobile Slide-by-Slide Carousel) -->
        <section class="bg-white py-10" x-data="{ activeSec7Slide: 0, maxSec7Slides: 3 }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header (Title, Subtitle & Mobile Slider Controls) -->
                <div class="mb-6 sm:mb-10 text-center">
                    <h2 class="text-[22px] sm:text-[28px] font-bold text-[#000000]">สายคล้องตามโอกาสการใช้งาน</h2>
                    <p class="text-[13px] sm:text-[14px] text-[#686868] mt-1.5">เลือกสายคล้องคอที่เหมาะสมกับการใช้งานของคุณ</p>

                    <!-- Circular Prev / Next Slider Buttons (Visible only on mobile < sm - Same style as Section 4 PC) -->
                    <div class="flex sm:hidden items-center justify-end space-x-2 mt-4 px-1">
                        <button @click="activeSec7Slide = Math.max(0, activeSec7Slide - 1)" 
                                :disabled="activeSec7Slide === 0" 
                                :class="activeSec7Slide === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-gray-100'"
                                aria-label="Previous slide"
                                class="w-9 h-9 rounded-full border border-[#E4E4E4] flex items-center justify-center transition-colors bg-white">
                            <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="activeSec7Slide = Math.min(maxSec7Slides - 1, activeSec7Slide + 1)" 
                                :disabled="activeSec7Slide === maxSec7Slides - 1" 
                                :class="activeSec7Slide === maxSec7Slides - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-gray-100'"
                                aria-label="Next slide"
                                class="w-9 h-9 rounded-full border border-[#E4E4E4] flex items-center justify-center transition-colors bg-white">
                            <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Desktop Grid Layout (Hidden on Mobile < sm) -->
                <div class="hidden sm:grid sm:grid-cols-3 gap-6">
                    <!-- Card 1: สำหรับบริษัท -->
                    <div class="bg-white rounded-2xl border border-[#E4E4E4] overflow-hidden flex flex-col justify-between shadow-xs transition-shadow hover:shadow-md">
                        <div>
                            <div class="w-full aspect-[16/9] overflow-hidden relative">
                                <img src="{{ asset('images/use-cases/company.png') }}?v={{ time() }}" alt="สำหรับบริษัท" class="w-full h-full object-cover" />
                            </div>
                            <div class="p-6">
                                <h3 class="text-[18px] font-bold text-[#000000] mb-3 text-left">สำหรับบริษัท</h3>
                                <p class="text-[13px] text-[#686868] leading-relaxed mb-6 text-left">สายคล้องคอสำหรับองค์กรและบริษัทต่างๆ ใช้ห้อยบัตรพนักงาน บัตรผ่านเข้า-ออก หรือบัตรประชุม ช่วยสร้างอัตลักษณ์องค์กรและเสริมภาพลักษณ์ที่เป็นมืออาชีพ พิมพ์โลโก้บริษัทได้ชัดเจน มีความทนทานสูง เหมาะสำหรับการใช้งานประจำวัน</p>
                                <span class="block text-[12px] font-medium text-[#888888] mb-2.5 text-left">สินค้าที่นิยม:</span>
                                <div class="space-y-2">
                                    <a href="/products/prod-2-2-180" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                        สายคล้องคอโพลีเอสเตอร์(สกรีนลาย)
                                    </a>
                                    <a href="/products/prod-9-9-296" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                        สายคล้องคอ Snap yoyo
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: สำหรับโรงเรียน -->
                    <div class="bg-white rounded-2xl border border-[#E4E4E4] overflow-hidden flex flex-col justify-between shadow-xs transition-shadow hover:shadow-md">
                        <div>
                            <div class="w-full aspect-[16/9] overflow-hidden relative">
                                <img src="{{ asset('images/use-cases/school.png') }}?v={{ time() }}" alt="สำหรับโรงเรียน" class="w-full h-full object-cover" />
                            </div>
                            <div class="p-6">
                                <h3 class="text-[18px] font-bold text-[#000000] mb-3 text-left">สำหรับโรงเรียน</h3>
                                <p class="text-[13px] text-[#686868] leading-relaxed mb-6 text-left">สายคล้องคอสำหรับสถาบันการศึกษา เหมาะสำหรับนักเรียน นักศึกษา ครู และบุคลากรทางการศึกษา ใช้ห้อยบัตรนักเรียน บัตรห้องสมุด หรือบัตรเข้างานกิจกรรมต่างๆ ราคาประหยัด คุณภาพดี สามารถสกรีนชื่อโรงเรียน สีประจำสถาบัน หรือสโลแกนได้ตามต้องการ</p>
                                <span class="block text-[12px] font-medium text-[#888888] mb-2.5 text-left">สินค้าที่นิยม:</span>
                                <div class="space-y-2">
                                    <a href="/products/prod-8-8-812" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                        สายคล้องคอแบบชุดสำเร็จรูป
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: สำหรับงานอีเวนต์ -->
                    <div class="bg-white rounded-2xl border border-[#E4E4E4] overflow-hidden flex flex-col justify-between shadow-xs transition-shadow hover:shadow-md">
                        <div>
                            <div class="w-full aspect-[16/9] overflow-hidden relative">
                                <img src="{{ asset('images/use-cases/event.png') }}?v={{ time() }}" alt="สำหรับงานอีเวนต์" class="w-full h-full object-cover" />
                            </div>
                            <div class="p-6">
                                <h3 class="text-[18px] font-bold text-[#000000] mb-3 text-left">สำหรับงานอีเวนต์</h3>
                                <p class="text-[13px] text-[#686868] leading-relaxed mb-6 text-left">สายคล้องคอสำหรับงานจัดกิจกรรมทุกประเภท ไม่ว่าจะเป็นงานสัมมนา คอนเสิร์ต งานแสดงสินค้า การประชุมใหญ่ หรืองานเทศกาล ช่วยระบุตัวตนผู้เข้าร่วมงาน แยกประเภทผู้เข้าชมได้ง่าย รองรับการพิมพ์ฟูลคัลเลอร์ ออกแบบได้อย่างอิสระตามธีมงานเป็นของที่ระลึกที่ดีสำหรับผู้เข้าร่วมงาน</p>
                                <span class="block text-[12px] font-medium text-[#888888] mb-2.5 text-left">สินค้าที่นิยม:</span>
                                <div class="space-y-2">
                                    <a href="/products/prod-4-4-701" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                        สายคล้องคอซับลิเมชั่น
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Slider Container (Visible only on mobile < sm: 1 card per slide with controls) -->
                <div class="block sm:hidden overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${activeSec7Slide * 100}%)`">
                        <!-- Slide 1: สำหรับบริษัท -->
                        <div class="w-full shrink-0">
                            <div class="bg-white rounded-2xl border border-[#E4E4E4] overflow-hidden flex flex-col justify-between shadow-xs">
                                <div class="w-full aspect-[16/9] overflow-hidden relative">
                                    <img src="{{ asset('images/use-cases/company.png') }}?v={{ time() }}" alt="สำหรับบริษัท" class="w-full h-full object-cover" />
                                </div>
                                <div class="p-6">
                                    <h3 class="text-[18px] font-bold text-[#000000] mb-3 text-left">สำหรับบริษัท</h3>
                                    <p class="text-[13px] text-[#686868] leading-relaxed mb-6 text-left">สายคล้องคอสำหรับองค์กรและบริษัทต่างๆ ใช้ห้อยบัตรพนักงาน บัตรผ่านเข้า-ออก หรือบัตรประชุม ช่วยสร้างอัตลักษณ์องค์กรและเสริมภาพลักษณ์ที่เป็นมืออาชีพ พิมพ์โลโก้บริษัทได้ชัดเจน มีความทนทานสูง เหมาะสำหรับการใช้งานประจำวัน</p>
                                    <span class="block text-[12px] font-medium text-[#888888] mb-2.5 text-left">สินค้าที่นิยม:</span>
                                    <div class="space-y-2">
                                        <a href="/products/prod-2-2-180" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                            สายคล้องคอโพลีเอสเตอร์(สกรีนลาย)
                                        </a>
                                        <a href="/products/prod-9-9-296" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                            สายคล้องคอ Snap yoyo
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 2: สำหรับโรงเรียน -->
                        <div class="w-full shrink-0">
                            <div class="bg-white rounded-2xl border border-[#E4E4E4] overflow-hidden flex flex-col justify-between shadow-xs">
                                <div class="w-full aspect-[16/9] overflow-hidden relative">
                                    <img src="{{ asset('images/use-cases/school.png') }}?v={{ time() }}" alt="สำหรับโรงเรียน" class="w-full h-full object-cover" />
                                </div>
                                <div class="p-6">
                                    <h3 class="text-[18px] font-bold text-[#000000] mb-3 text-left">สำหรับโรงเรียน</h3>
                                    <p class="text-[13px] text-[#686868] leading-relaxed mb-6 text-left">สายคล้องคอสำหรับสถาบันการศึกษา เหมาะสำหรับนักเรียน นักศึกษา ครู และบุคลากรทางการศึกษา ใช้ห้อยบัตรนักเรียน บัตรห้องสมุด หรือบัตรเข้างานกิจกรรมต่างๆ ราคาประหยัด คุณภาพดี สามารถสกรีนชื่อโรงเรียน สีประจำสถาบัน หรือสโลแกนได้ตามต้องการ</p>
                                    <span class="block text-[12px] font-medium text-[#888888] mb-2.5 text-left">สินค้าที่นิยม:</span>
                                    <div class="space-y-2">
                                        <a href="/products/prod-8-8-812" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                            สายคล้องคอแบบชุดสำเร็จรูป
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide 3: สำหรับงานอีเวนต์ -->
                        <div class="w-full shrink-0">
                            <div class="bg-white rounded-2xl border border-[#E4E4E4] overflow-hidden flex flex-col justify-between shadow-xs">
                                <div class="w-full aspect-[16/9] overflow-hidden relative">
                                    <img src="{{ asset('images/use-cases/event.png') }}?v={{ time() }}" alt="สำหรับงานอีเวนต์" class="w-full h-full object-cover" />
                                </div>
                                <div class="p-6">
                                    <h3 class="text-[18px] font-bold text-[#000000] mb-3 text-left">สำหรับงานอีเวนต์</h3>
                                    <p class="text-[13px] text-[#686868] leading-relaxed mb-6 text-left">สายคล้องคอสำหรับงานจัดกิจกรรมทุกประเภท ไม่ว่าจะเป็นงานสัมมนา คอนเสิร์ต งานแสดงสินค้า การประชุมใหญ่ หรืองานเทศกาล ช่วยระบุตัวตนผู้เข้าร่วมงาน แยกประเภทผู้เข้าชมได้ง่าย รองรับการพิมพ์ฟูลคัลเลอร์ ออกแบบได้อย่างอิสระตามธีมงานเป็นของที่ระลึกที่ดีสำหรับผู้เข้าร่วมงาน</p>
                                    <span class="block text-[12px] font-medium text-[#888888] mb-2.5 text-left">สินค้าที่นิยม:</span>
                                    <div class="space-y-2">
                                        <a href="/products/prod-4-4-701" class="block w-full bg-[#F3F3F3] hover:bg-[#E8E8E8] text-[#000000] text-[13px] font-medium py-2.5 px-4 rounded-xl transition-colors text-left">
                                            สายคล้องคอซับลิเมชั่น
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 8: ภาพแบนเนอร์ Best Seller (Desktop: Centered max-w-6xl with larger top/bottom spacing | Mobile: Full-width edge-to-edge rectangular with no rounded corners) -->
        <section class="my-4 sm:my-16 py-2">
            <!-- Desktop Layout (Visible only on PC >= sm) -->
            <div class="hidden sm:block max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <a href="#all-products" class="inline-block w-full group overflow-hidden rounded-2xl">
                    <img src="{{ asset('images/bestseller-banner.png') }}?v={{ time() }}" 
                         alt="5 อันดับ สินค้าขายดี Best Seller" 
                         class="w-full h-auto mx-auto object-cover rounded-2xl group-hover:scale-[1.01] transition-transform duration-300 shadow-xs hover:shadow-md" />
                </a>
            </div>

            <!-- Mobile Layout (Visible only on Mobile < sm: Full-width 100% edge-to-edge rectangular no rounded corners) -->
            <div class="block sm:hidden w-full">
                <a href="#all-products" class="block w-full group">
                    <img src="{{ asset('images/bestseller-banner-mobile.jpg') }}?v={{ time() }}" 
                         alt="5 อันดับ สินค้าขายดี Best Seller Mobile" 
                         class="w-full h-auto object-cover rounded-none group-hover:opacity-95 transition-opacity" />
                </a>
            </div>
        </section>

        <!-- SECTION 9: ลูกค้าของเรา (Desktop: Image 3 | Mobile: Image 4 Vertical Stack) -->
        <section class="py-8 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Title -->
                <h2 class="text-[20px] sm:text-[24px] font-bold text-[#000000] mb-6 sm:mb-8 text-center">ลูกค้าของเรา</h2>
                
                <!-- Desktop Layout (Image 3 - PC Grid) -->
                <div class="hidden sm:block w-full text-center">
                    <img src="{{ asset('images/clients-grid.png') }}?v={{ time() }}" 
                         alt="ลูกค้าของเรา" 
                         class="max-w-4xl w-full h-auto mx-auto" />
                </div>

                <!-- Mobile Layout (Image 4 - Vertical Stack) -->
                <div class="block sm:hidden w-full text-center">
                    <img src="{{ asset('images/clients-grid-mobile.png') }}?v={{ time() }}" 
                         alt="ลูกค้าของเรา Mobile" 
                         class="max-w-[320px] w-full h-auto mx-auto" />
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
