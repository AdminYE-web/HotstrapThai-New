<x-app-layout>
@php
    $accessorySlugs = ['badge-holders', 'yoyo-badge-holders', 'lanyard-parts', 'carabiners'];
    $mainCats       = $categories->filter(fn($c) => !in_array($c->slug, $accessorySlugs));
    $accessoryCats  = $categories->filter(fn($c) =>  in_array($c->slug, $accessorySlugs));

    $initialTitle    = 'สินค้าทั้งหมด';
    $initialSubtitle = 'ค้นหาสินค้าที่ใช่สำหรับคุณ ด้วยระบบกรองสินค้าอัจฉริยะ';

    if (request()->has('category_slugs') && is_array(request()->category_slugs) && count(request()->category_slugs) === 1) {
        $firstSlug = request()->category_slugs[0];
        $catObj = $categories->firstWhere('slug', $firstSlug);
        if ($catObj) {
            $initialTitle    = $catObj->name;
            $initialSubtitle = 'แสดงสินค้าในหมวดหมู่ ' . $initialTitle;
        }
    } elseif (request()->has('print_types') && is_array(request()->print_types) && count(request()->print_types) === 1) {
        if (request()->print_types[0] === 'screened') {
            $initialTitle    = 'สายคล้องสกรีนลาย';
            $initialSubtitle = 'สายคล้องบัตรพิมพ์ลายสกรีนตามแบบที่คุณต้องการ';
        } elseif (request()->print_types[0] === 'plain') {
            $initialTitle    = 'สายคล้องไม่สกรีนลาย';
            $initialSubtitle = 'สายคล้องบัตรสำเร็จรูป พร้อมใช้งานทันที';
        }
    } elseif (request()->filled('is_ready_to_ship') && request()->is_ready_to_ship == '1') {
        $initialTitle    = 'สินค้าพร้อมส่ง';
        $initialSubtitle = 'สินค้าที่มีพร้อมจัดส่งทันที';
    } elseif (request()->has('occasions') && is_array(request()->occasions) && count(request()->occasions) === 1) {
        $usageMap = ['office' => 'สำนักงานบริษัท', 'school' => 'โรงเรียน', 'event' => 'งานอีเว้นท์'];
        $initialTitle    = $usageMap[request()->occasions[0]] ?? request()->occasions[0];
        $initialSubtitle = 'สินค้าสำหรับ' . $initialTitle;
    }
@endphp
<div class="bg-[#F2F4F8] min-h-screen">

    {{-- Top Sticky Filter Bar (desktop only) --}}
    @include('products.partials.top-filter-bar')

    {{-- Mobile Filter Drawer (slide from left) --}}
    @include('products.partials.mobile-filter-drawer')

    {{-- ══════════════════════════════════════════════
         PAGE CONTENT
    ══════════════════════════════════════════════ --}}
    <div class="page-wrapper">

        {{-- Breadcrumb (hidden on mobile) --}}
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">หน้าหลัก</a>
            <span>›</span>
            <span class="breadcrumb-current" id="breadcrumbCurrent">{{ $initialTitle }}</span>
        </nav>

        {{-- Screen Banner Slider --}}
        @include('products.partials.screen-slider')

        {{-- Mobile Filter Trigger (mobile only) --}}
        <div class="mobile-filter-trigger" id="mobileFilterTrigger" onclick="openMobileFilter()">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <span>กรองสินค้า</span>
        </div>

        {{-- Page Header (dynamic title via JS) --}}
        <div class="page-header">
            <h1 id="pageTitle">{{ $initialTitle }}</h1>
            <p id="pageSubtitle" class="desktop-only">{{ $initialSubtitle }}</p>
        </div>

        {{-- Content Layout --}}
        <div class="content-layout">

            {{-- Sidebar Filter (desktop only) --}}
            @include('products.partials.sidebar-filter')

            {{-- ── PRODUCTS AREA ── --}}
            <div class="products-area">
                {{-- Toolbar --}}
                <div class="toolbar">
                    <span class="products-count">
                        แสดงสินค้า <strong id="countNum">{{ $products->total() }}</strong> รายการ
                    </span>
                    <select class="sort-select" id="sortSelect" onchange="doFetch()">
                        <option value="oldest" selected>เรียง: ID 1 เป็นต้นไป</option>
                        <option value="latest">ล่าสุด</option>
                        <option value="price_low">ราคา: ต่ำ → สูง</option>
                        <option value="price_high">ราคา: สูง → ต่ำ</option>
                    </select>
                </div>

                {{-- Product Grid --}}
                <div class="product-grid" id="productGrid">
                    @forelse ($products as $product)
                        @include('products.partials.product-card', ['product' => $product])
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                            <h3 class="empty-title">ไม่พบสินค้าที่ตรงตามเงื่อนไขที่เลือก</h3>
                            <p class="empty-desc">ลองเปลี่ยนเงื่อนไขการกรองหรือล้างตัวกรองทั้งหมด</p>
                            <button class="empty-reset-btn" onclick="resetFilters()">ล้างตัวกรองทั้งหมด</button>
                        </div>
                    @endforelse
                </div>

                {{-- Infinite Scroll Sentinel --}}
                <div id="scroll-sentinel" style="height:1px;margin-top:24px;"></div>
                <div id="loading-indicator" style="display:none;text-align:center;padding:24px;">
                    <div class="spinner"></div>
                </div>
            </div>

        </div>{{-- /content-layout --}}
    </div>{{-- /page-wrapper --}}

    {{-- Scroll to Top Button --}}
    <button class="scroll-to-top" id="scrollToTop" onclick="scrollToTop()" aria-label="กลับขึ้นด้านบน">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

</div>

{{-- ══════════════════════════════════════════════
     CSS (external file)
══════════════════════════════════════════════ --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/products-index.css') }}">
@endpush

{{-- ══════════════════════════════════════════════
     JAVASCRIPT
     Config variables (Blade data) defined inline,
     then external JS file loaded.
══════════════════════════════════════════════ --}}
<script>
/* ─── CONFIG (requires Blade template data) ─── */
const BASE_URL  = '{{ route('products.index') }}';
let   nextPage  = '{{ $products->nextPageUrl() ?? '' }}';
let   hasMore   = {{ $products->hasMorePages() ? 'true' : 'false' }};
let   fetchTimer = null;
let   isFetching = false;
</script>
<script src="{{ asset('js/products-index.js') }}"></script>

</x-app-layout>
