{{-- ══════════════════════════════════════════════
     SIDEBAR FILTER
══════════════════════════════════════════════ --}}
<aside id="sidebarFilter">
    <div class="sidebar-card">
        <div class="sidebar-head">
            <span class="sidebar-title">
                <svg width="15" height="15" fill="none" stroke="#004998" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                ตัวกรองสินค้า
            </span>
        </div>

        <div class="sidebar-body">

            {{-- 1. ประเภทสินค้า (Screen / No-Screen) --}}
            <div class="filter-block">
                <div class="filter-block-title">ประเภทสินค้า</div>
                <div class="checkbox-list">
                    <label class="checkbox-item checked" id="sb-lbl-all">
                        <input type="checkbox" id="sb-type-all" value="all"
                               onchange="onFilterAll(this.checked)" checked> สินค้าทั้งหมด
                    </label>
                    <label class="checkbox-item" id="sb-lbl-screen">
                        <input type="checkbox" id="sb-type-screen" value="screen"
                               onchange="onFilter('types','screen',this.checked)"> สกรีนลาย
                    </label>
                    <label class="checkbox-item" id="sb-lbl-noscreen">
                        <input type="checkbox" id="sb-type-noscreen" value="noscreen"
                               onchange="onFilter('types','noscreen',this.checked)"> ไม่สกรีนลาย
                    </label>
                </div>
            </div>

            {{-- 2. หมวดหมู่สินค้า (from DB) --}}
            <div class="filter-block">
                <div class="filter-block-title">หมวดหมู่</div>
                <div class="checkbox-list">
                    {{-- Main lanyard categories --}}
                    @foreach($mainCats as $cat)
                    <label class="checkbox-item" id="sb-lbl-cat-{{ $cat->slug }}">
                        <input type="checkbox" id="sb-cat-{{ $cat->slug }}"
                               class="sb-cat-cb" value="{{ $cat->slug }}"
                               onchange="onFilter('categories','{{ $cat->slug }}',this.checked)">
                        {{ $cat->name }}
                        @if($cat->products_count > 0)
                            <span style="margin-left:auto;font-size:11px;color:#9CA3AF;">({{ $cat->products_count }})</span>
                        @endif
                    </label>
                    @endforeach

                    {{-- อุปกรณ์เสริม collapsible group --}}
                    @if($accessoryCats->isNotEmpty())
                    <div class="acc-group" id="accGroup">
                        <button type="button" class="acc-group-header" id="accGroupToggle"
                                onclick="toggleAccGroup()" aria-expanded="false">
                            <span>อุปกรณ์เสริม</span>
                            <span class="acc-chevron" id="accChevron">&#8250;</span>
                        </button>
                        <div class="acc-group-body" id="accGroupBody" style="display:none;">
                            @foreach($accessoryCats as $cat)
                            <label class="checkbox-item acc-checkbox-item" id="sb-lbl-cat-{{ $cat->slug }}">
                                <input type="checkbox" id="sb-cat-{{ $cat->slug }}"
                                       class="sb-cat-cb acc-cat-cb" value="{{ $cat->slug }}"
                                       onchange="onFilter('categories','{{ $cat->slug }}',this.checked)">
                                {{ $cat->name }}
                                @if($cat->products_count > 0)
                                    <span style="margin-left:auto;font-size:11px;color:#9CA3AF;">({{ $cat->products_count }})</span>
                                @endif
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- 3. ความพร้อมจำหน่าย --}}
            <div class="filter-block">
                <div class="filter-block-title">ความพร้อมจำหน่าย</div>
                <div class="checkbox-list">
                    <label class="checkbox-item" id="sb-lbl-avail">
                        <input type="checkbox" id="sb-avail"
                               onchange="onFilter('availability',null,this.checked)"> สินค้าพร้อมส่ง
                    </label>
                </div>
            </div>

            {{-- 4. ตามการใช้งาน --}}
            <div class="filter-block">
                <div class="filter-block-title">ตามการใช้งาน</div>
                <div class="checkbox-list">
                    <label class="checkbox-item" id="sb-lbl-office">
                        <input type="checkbox" id="sb-usage-office" value="office"
                               onchange="onFilter('usages','office',this.checked)"> สำนักงานบริษัท
                    </label>
                    <label class="checkbox-item" id="sb-lbl-school">
                        <input type="checkbox" id="sb-usage-school" value="school"
                               onchange="onFilter('usages','school',this.checked)"> โรงเรียน
                    </label>
                    <label class="checkbox-item" id="sb-lbl-event">
                        <input type="checkbox" id="sb-usage-event" value="event"
                               onchange="onFilter('usages','event',this.checked)"> งานอีเว้นท์
                    </label>
                </div>
            </div>

        </div>
    </div>
</aside>
