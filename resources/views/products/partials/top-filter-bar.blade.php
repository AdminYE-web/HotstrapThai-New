{{-- ══════════════════════════════════════════════
     TOP STICKY FILTER BAR
     Hidden at top, slides down when sidebar scrolls out of view
══════════════════════════════════════════════ --}}
<div id="topFilterBar">
    <span class="top-bar-brand"><i class="fa-solid fa-sliders" style="margin-right:6px;"></i>กรองสินค้า</span>

    {{-- ประเภทสินค้า --}}
    <div class="top-filter-group">
        <button id="pill-type" class="top-filter-pill" data-target="dp-type">
            ประเภทสินค้า
            <span class="pill-badge" id="badge-type" style="display:none"></span>
            <span class="chevron"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="dropdown-panel" id="dp-type">
            <label class="dropdown-option">
                <input type="checkbox" id="top-type-all" value="all" onchange="onFilterAll(this.checked)" checked> สินค้าทั้งหมด
            </label>
            <label class="dropdown-option">
                <input type="checkbox" id="top-type-screen" value="screen" onchange="onFilter('types','screen',this.checked)"> สกรีนลาย
            </label>
            <label class="dropdown-option">
                <input type="checkbox" id="top-type-noscreen" value="noscreen" onchange="onFilter('types','noscreen',this.checked)"> ไม่สกรีนลาย
            </label>
        </div>
    </div>

    <div class="top-divider"></div>

    {{-- หมวดหมู่ --}}
    <div class="top-filter-group">
        <button id="pill-cat" class="top-filter-pill" data-target="dp-cat">
            หมวดหมู่
            <span class="pill-badge" id="badge-cat" style="display:none"></span>
            <span class="chevron"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="dropdown-panel" id="dp-cat">
            {{-- Main lanyard categories --}}
            @foreach($mainCats as $cat)
            <label class="dropdown-option">
                <input type="checkbox" class="top-cat-cb" value="{{ $cat->slug }}"
                       onchange="onFilter('categories','{{ $cat->slug }}',this.checked)">
                {{ $cat->name }}
            </label>
            @endforeach

            {{-- อุปกรณ์เสริม flyout row --}}
            @if($accessoryCats->isNotEmpty())
            <div class="top-acc-row" id="topAccRow">
                <button type="button" class="top-acc-trigger" id="topAccTrigger"
                        onclick="toggleTopAccPanel(event)">
                    <span>อุปกรณ์เสริม</span>
                    <span class="top-acc-chevron" id="topAccChevron">&#8250;</span>
                </button>
                <div class="top-acc-panel" id="topAccPanel">
                    @foreach($accessoryCats as $cat)
                    <label class="dropdown-option">
                        <input type="checkbox" class="top-cat-cb top-acc-cb" value="{{ $cat->slug }}"
                               onchange="onFilter('categories','{{ $cat->slug }}',this.checked)">
                        {{ $cat->name }}
                    </label>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="top-divider"></div>

    {{-- พร้อมส่ง --}}
    <div class="top-filter-group">
        <button id="pill-avail" class="top-filter-pill" onclick="toggleAvail()">
            สินค้าพร้อมส่ง
            <span class="pill-badge" id="badge-avail" style="display:none"><i class="fa-solid fa-check"></i></span>
        </button>
    </div>

    <div class="top-divider"></div>

    {{-- การใช้งาน --}}
    <div class="top-filter-group">
        <button id="pill-usage" class="top-filter-pill" data-target="dp-usage">
            การใช้งาน
            <span class="pill-badge" id="badge-usage" style="display:none"></span>
            <span class="chevron"><i class="fa-solid fa-chevron-down"></i></span>
        </button>
        <div class="dropdown-panel" id="dp-usage">
            <label class="dropdown-option">
                <input type="checkbox" id="top-usage-office" value="office" onchange="onFilter('usages','office',this.checked)"> สำนักงานบริษัท
            </label>
            <label class="dropdown-option">
                <input type="checkbox" id="top-usage-school" value="school" onchange="onFilter('usages','school',this.checked)"> โรงเรียน
            </label>
            <label class="dropdown-option">
                <input type="checkbox" id="top-usage-event" value="event" onchange="onFilter('usages','event',this.checked)"> งานอีเว้นท์
            </label>
        </div>
    </div>

    <button class="top-reset-btn" onclick="resetFilters()"><i class="fa-solid fa-xmark" style="margin-right:4px;"></i>ล้างทั้งหมด</button>
</div>
