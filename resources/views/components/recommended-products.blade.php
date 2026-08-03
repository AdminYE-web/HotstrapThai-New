<section class="py-10 bg-[#F3F3F3] font-sans" x-data="{
    activePage: 0,
    pageSize: 5,
    products: [
        { id: 1, title: 'สายคล้องคอ Snap yoyo', image: '{{ asset('images/products/lanyard-snap-yoyo.png') }}', tag: 'ยอดนิยม' },
        { id: 2, title: 'สายคล้องคอติดโลโก้เรซิ่น', image: '{{ asset('images/products/lanyard-resin-logo.png') }}', tag: 'แนะนำ' },
        { id: 3, title: 'สายคล้องคอต้านเชื้อแบคทีเรีย', image: '{{ asset('images/products/lanyard-antibacterial.png') }}', tag: 'ขายดี' },
        { id: 4, title: 'สายคล้องคอผ้าแจ็คการ์ด', image: '{{ asset('images/products/lanyard-jacquard.png') }}', tag: 'พรีเมียม' },
        { id: 5, title: 'สายคล้องคอสกรีนซับลิเมชั่น', image: '{{ asset('images/products/lanyard-sublimation.png') }}', tag: 'ฮิต' },
        { id: 6, title: 'สายคล้องคอผ้าโพลีเอสเตอร์', image: '{{ asset('images/products/lanyard-polyester.png') }}', tag: 'คุ้มค่า' },
        { id: 7, title: 'สายคล้องคอผ้าไนลอน', image: '{{ asset('images/products/lanyard-nylon.png') }}', tag: 'อุปกรณ์' },
        { id: 8, title: 'สายคล้องคอพรีเมี่ยม', image: '{{ asset('images/products/lanyard-premium.png') }}', tag: 'อุปกรณ์' },
        { id: 9, title: 'สายคล้องคอ Snap yoyo', image: '{{ asset('images/products/lanyard-snap-yoyo.png') }}', tag: 'อุปกรณ์' },
        { id: 10, title: 'สายคล้องคอติดโลโก้เรซิ่น', image: '{{ asset('images/products/lanyard-resin-logo.png') }}', tag: 'สั่งทำ' }
    ],
    get maxPage() {
        return Math.ceil(this.products.length / this.pageSize) - 1;
    },
    nextPage() {
        if (this.activePage < this.maxPage) {
            this.activePage++;
        } else {
            this.activePage = 0;
        }
    },
    prevPage() {
        if (this.activePage > 0) {
            this.activePage--;
        } else {
            this.activePage = this.maxPage;
        }
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header with Arrows (Font 20px) -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-[20px] font-bold text-[#000000] tracking-tight">
                คุณอาจจะชอบสิ่งนี้
            </h2>

            <!-- Desktop Arrow Controls (Color #000000) -->
            <div class="hidden sm:flex items-center space-x-2">
                <button @click="prevPage()" class="w-9 h-9 rounded-full border border-[#E4E4E4] bg-white hover:bg-gray-100 flex items-center justify-center text-[#000000] transition-all focus:outline-none active:scale-95 shadow-xs" title="ก่อนหน้า">
                    <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="nextPage()" class="w-9 h-9 rounded-full border border-[#E4E4E4] bg-white hover:bg-gray-100 flex items-center justify-center text-[#000000] transition-all focus:outline-none active:scale-95 shadow-xs" title="ถัดไป">
                    <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Desktop Grid (Card Bg: #F8F8F8, Title Font: 14px) -->
        <div class="hidden sm:block overflow-hidden">
            <div class="grid grid-cols-5 gap-4 lg:gap-5 transition-all duration-500 ease-in-out">
                <template x-for="(product, index) in products.slice(activePage * pageSize, (activePage + 1) * pageSize)" :key="product.id">
                    <a :href="'/product/' + product.id" class="group bg-[#F8F8F8] rounded-xl shadow-xs hover:shadow-md border border-[#E4E4E4] transition-all duration-300 flex flex-col h-full overflow-hidden transform hover:-translate-y-1">
                        <div class="bg-white p-4 flex items-center justify-center aspect-square relative overflow-hidden group-hover:bg-gray-50 transition-colors">
                            <span class="absolute top-2 left-2 bg-[#122244] text-white text-[10px] font-bold px-2 py-0.5 rounded-full z-10 shadow-xs" x-text="product.tag"></span>
                            
                            <div class="w-full h-full flex items-center justify-center transform group-hover:scale-105 transition-transform duration-300">
                                <img :src="product.image" :alt="product.title" class="w-full h-full object-contain p-2" />
                            </div>
                        </div>

                        <div class="p-4 bg-[#F8F8F8] flex-1 flex flex-col justify-between">
                            <h3 class="text-[14px] font-semibold text-[#000000] text-center line-clamp-2" x-text="product.title"></h3>
                            
                            <div class="mt-3 pt-2 border-t border-[#E4E4E4] flex items-center justify-center text-xs text-[#005ABA] font-bold group-hover:underline">
                                <span>ดูรายละเอียด</span>
                                <svg class="w-3.5 h-3.5 ml-1 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </template>
            </div>
        </div>

        <!-- Mobile Touch Slider -->
        <div class="sm:hidden relative">
            <div class="flex space-x-4 overflow-x-auto pb-4 pt-1 snap-x snap-mandatory scrollbar-none" style="-webkit-overflow-scrolling: touch;">
                <template x-for="product in products" :key="product.id">
                    <a :href="'/product/' + product.id" class="snap-start flex-none w-[65vw] max-w-[240px] bg-[#F8F8F8] rounded-xl shadow-xs border border-[#E4E4E4] overflow-hidden flex flex-col">
                        <div class="bg-white p-4 aspect-square flex items-center justify-center relative">
                            <span class="absolute top-2 left-2 bg-[#122244] text-white text-[10px] font-bold px-2 py-0.5 rounded-full" x-text="product.tag"></span>
                            <img :src="product.image" :alt="product.title" class="w-full h-full object-contain p-2" />
                        </div>
                        <div class="p-3.5 bg-[#F8F8F8] flex-1 flex flex-col justify-between">
                            <h3 class="text-[14px] font-semibold text-[#000000] text-center line-clamp-2" x-text="product.title"></h3>
                            <span class="text-[12px] text-[#005ABA] font-bold text-center mt-2">ดูรายละเอียด &rarr;</span>
                        </div>
                    </a>
                </template>
            </div>
            <p class="text-[11px] text-gray-500 text-center mt-1">💡 ใช้นิ้วปัดซ้าย-ขวา เพื่อดูสินค้าทั้งหมด</p>
        </div>

    </div>
</section>
