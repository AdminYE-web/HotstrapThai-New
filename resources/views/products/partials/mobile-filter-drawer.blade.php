{{-- ══════════════════════════════════════════════
     MOBILE FILTER DRAWER (slide from left)
══════════════════════════════════════════════ --}}

{{-- Overlay backdrop --}}
<div class="mobile-filter-overlay" id="mobileFilterOverlay" onclick="closeMobileFilter()"></div>

{{-- Drawer panel --}}
<div class="mobile-filter-drawer" id="mobileFilterDrawer">
    <div class="mobile-filter-head">
        <button class="mobile-filter-close" onclick="closeMobileFilter()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="mobile-filter-body">

        {{-- ประเภทสินค้า --}}
        <div class="mobile-filter-section">
            <div class="mobile-filter-title">ประเภทสินค้า</div>
            <label class="mobile-filter-option checked" id="mob-lbl-all">
                <input type="checkbox" id="mob-type-all" value="all"
                       onchange="onFilterAll(this.checked)" checked>
                <span>สินค้าทั้งหมด</span>
            </label>
            <label class="mobile-filter-option" id="mob-lbl-screen">
                <input type="checkbox" id="mob-type-screen" value="screen"
                       onchange="onFilter('types','screen',this.checked)">
                <span>สายคล้องสกรีนลาย</span>
            </label>
            <label class="mobile-filter-option" id="mob-lbl-noscreen">
                <input type="checkbox" id="mob-type-noscreen" value="noscreen"
                       onchange="onFilter('types','noscreen',this.checked)">
                <span>สายคล้องไม่สกรีนลาย</span>
            </label>
        </div>

        {{-- หมวดหมู่ --}}
        <div class="mobile-filter-section">
            <div class="mobile-filter-title">หมวดหมู่</div>
            @foreach($mainCats as $cat)
            <label class="mobile-filter-option" id="mob-lbl-cat-{{ $cat->slug }}">
                <input type="checkbox" class="mob-cat-cb" value="{{ $cat->slug }}"
                       onchange="onFilter('categories','{{ $cat->slug }}',this.checked)">
                <span>{{ $cat->name }}</span>
            </label>
            @endforeach

            {{-- อุปกรณ์เสริม (expandable) --}}
            @if($accessoryCats->isNotEmpty())
            <div class="mobile-acc-group">
                <button type="button" class="mobile-filter-option mobile-acc-trigger" id="mobAccTrigger"
                        onclick="toggleMobileAcc()">
                    <input type="checkbox" style="visibility:hidden;width:16px;height:16px;" disabled>
                    <span>อุปกรณ์เสริม</span>
                    <span class="mobile-acc-arrow" id="mobileAccArrow">›</span>
                </button>
                <div class="mobile-acc-body" id="mobileAccBody" style="display:none;">
                    @foreach($accessoryCats as $cat)
                    <label class="mobile-filter-option mobile-filter-sub" id="mob-lbl-cat-{{ $cat->slug }}">
                        <input type="checkbox" class="mob-cat-cb mob-acc-cb" value="{{ $cat->slug }}"
                               onchange="onFilter('categories','{{ $cat->slug }}',this.checked)">
                        <span>{{ $cat->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- ความพร้อมจำหน่าย --}}
        <div class="mobile-filter-section">
            <div class="mobile-filter-title">ความพร้อมจำหน่าย</div>
            <label class="mobile-filter-option" id="mob-lbl-avail">
                <input type="checkbox" id="mob-avail"
                       onchange="onFilter('availability',null,this.checked)">
                <span>สินค้าพร้อมส่ง</span>
            </label>
        </div>

        {{-- ตามการใช้งาน --}}
        <div class="mobile-filter-section">
            <div class="mobile-filter-title">ตามการใช้งาน(Usage/Industry)</div>
            <label class="mobile-filter-option" id="mob-lbl-office">
                <input type="checkbox" id="mob-usage-office" value="office"
                       onchange="onFilter('usages','office',this.checked)">
                <span>สำนักงานบริษัท</span>
            </label>
            <label class="mobile-filter-option" id="mob-lbl-school">
                <input type="checkbox" id="mob-usage-school" value="school"
                       onchange="onFilter('usages','school',this.checked)">
                <span>โรงเรียน</span>
            </label>
            <label class="mobile-filter-option" id="mob-lbl-event">
                <input type="checkbox" id="mob-usage-event" value="event"
                       onchange="onFilter('usages','event',this.checked)">
                <span>งานอีเว้นท์</span>
            </label>
        </div>

    </div>
</div>
