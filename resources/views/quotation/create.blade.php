<x-app-layout>
<div class="bg-gray-50 min-h-screen py-10">
    <div style="max-width:780px; margin:0 auto; padding:0 24px;">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900">ขอใบเสนอราคา</h1>
        </div>

        <form action="{{ route('quotation.store') }}" method="POST" id="quotation-form" novalidate>
            @csrf
            <input type="hidden" name="address" id="full-address-input">
            <input type="hidden" name="tax_address" id="full-tax-address-input">
            <input type="hidden" name="tax_invoice_type" id="tax_invoice_type" value="none">

            {{-- ==================== STEP 1: เลือกใบกำกับภาษี ==================== --}}
            <div id="step-1">
                <div class="section-title">ใบกำกับภาษี</div>

                {{-- ไม่ต้องการ --}}
                <label id="tax-opt-none" class="tax-card active flex items-center gap-3 p-4 border-2 rounded cursor-pointer mb-3"
                       onclick="selectTaxType('none')">
                    <span class="tax-dot"></span>
                    <span class="text-sm font-semibold text-gray-800">ไม่ต้องการใบกำกับภาษี</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </label>

                {{-- แบบกระดาษ --}}
                <label id="tax-opt-paper" class="tax-card flex items-center gap-3 p-4 border-2 rounded cursor-pointer mb-3"
                       onclick="selectTaxType('paper')">
                    <span class="tax-dot"></span>
                    <span class="text-sm font-semibold text-gray-800">แบบกระดาษ</span>
                    <svg class="w-5 h-5 text-gray-400 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </label>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 pt-6">
                    <a href="{{ route('cart.index') }}" class="w-full sm:w-auto text-center px-6 py-2.5 bg-[#004998] hover:bg-[#003774] text-white font-semibold rounded text-sm">ย้อนกลับ</a>
                    <button type="button" onclick="nextFromStep1()" class="w-full sm:w-auto px-8 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded text-sm">ถัดไป</button>
                </div>
            </div>

            {{-- ==================== STEP 2: ข้อมูลใบกำกับภาษี (เฉพาะแบบกระดาษ) ==================== --}}
            <div id="step-2" class="hidden">
                <div class="section-title">ประเภทการขอใบกำกับภาษี</div>
                <div class="flex items-center gap-6 mb-5">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="tax_person_type" value="individual" checked class="w-4 h-4 text-[#004998]" onchange="toggleBranch()">
                        <span class="text-sm text-gray-700">บุคคลธรรมดา</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="tax_person_type" value="corporate" class="w-4 h-4 text-[#004998]" onchange="toggleBranch()">
                        <span class="text-sm text-gray-700">นิติบุคคล</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px;">
                    <div>
                        <label class="form-label">ชื่อ - นามสกุล <span class="text-red-500">*</span></label>
                        <input type="text" name="tax_name" required class="form-input">
                    </div>
                    <div>
                        <label class="form-label">เบอร์โทรศัพท์ <span class="text-red-500">*</span></label>
                        <input type="tel" name="tax_phone" required class="form-input">
                    </div>
                </div>

                <div id="tax-branch-row" class="hidden mt-4 text-sm">
                    <label class="form-label">สำนักงาน / สาขา <span class="text-red-500">*</span></label>
                    <input type="text" name="tax_branch" class="form-input sm:w-1/2">
                </div>

                <div class="mt-6">
                    <div class="section-title">ที่อยู่ในใบกำกับภาษี</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px;">
                        <div class="sm:col-span-2">
                            <label class="form-label">เลขประจำตัวผู้เสียภาษี <span class="text-red-500">*</span></label>
                            <input type="text" name="tax_id" required class="form-input">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px; margin-top: 28px;">
                        <div>
                            <label class="form-label">จังหวัด <span class="text-red-500">*</span></label>
                            <select id="tax_province_select" required class="form-input"><option value="">-- เลือกจังหวัด --</option></select>
                        </div>
                        <div>
                            <label class="form-label">อำเภอ / เขต <span class="text-red-500">*</span></label>
                            <select id="tax_district_select" required disabled class="form-input"><option value="">-- เลือกอำเภอ / เขต --</option></select>
                        </div>
                        <div>
                            <label class="form-label">ตำบล / แขวง <span class="text-red-500">*</span></label>
                            <select id="tax_subdistrict_select" required disabled class="form-input"><option value="">-- เลือกตำบล / แขวง --</option></select>
                        </div>
                        <div>
                            <label class="form-label">รหัสไปรษณีย์ <span class="text-red-500">*</span></label>
                            <input type="text" id="tax_zipcode_input" required readonly class="form-input bg-gray-50">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 text-sm" style="gap: 28px 24px; margin-top: 28px;">
                        <div>
                            <label class="form-label">เลขที่ <span class="text-red-500">*</span></label>
                            <input type="text" id="tax_addr_no" required class="form-input">
                        </div>
                        <div>
                            <label class="form-label">ชั้นที่</label>
                            <input type="text" id="tax_floor" class="form-input">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="form-label">ชื่ออาคาร</label>
                            <input type="text" id="tax_building" class="form-input">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px; margin-top: 28px;">
                        <div>
                            <label class="form-label">หมู่</label>
                            <input type="text" id="tax_moo" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">หมู่บ้าน</label>
                            <input type="text" id="tax_village" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">ซอย</label>
                            <input type="text" id="tax_soi" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">ถนน</label>
                            <input type="text" id="tax_road" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-sm">
                    <label class="form-label">ข้อความเพิ่มเติม <span class="text-xs text-gray-400 font-normal">กรุณาระบุข้อมูล หรือข้อความ ตามที่ท่านต้องการ กรณีไม่มีข้อมูลให้เว้นว่างไว้ไม่ต้องใส่ - (ขีด)</span></label>
                    <textarea name="note" rows="3" class="form-input"></textarea>
                </div>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 pt-6">
                    <button type="button" onclick="goTo('step-1')" class="w-full sm:w-auto px-6 py-2.5 bg-[#004998] hover:bg-[#003774] text-white font-semibold rounded text-sm">ย้อนกลับ</button>
                    <button type="button" onclick="nextFromStep2()" class="w-full sm:w-auto px-8 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded text-sm">ถัดไป</button>
                </div>
            </div>

            {{-- ==================== STEP 3: ที่อยู่ในการรับสินค้า ==================== --}}
            <div id="step-3" class="hidden">
                <div class="section-title">ที่อยู่ในการรับสินค้า</div>

                <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px;">
                    <div>
                        <label class="form-label">ชื่อ - นามสกุล <span class="text-red-500">*</span></label>
                        <input type="text" name="customer_name" required class="form-input">
                    </div>
                    <div>
                        <label class="form-label">เบอร์โทรศัพท์ <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" required class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">อีเมล <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required class="form-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px; margin-top: 28px;">
                    <div>
                        <label class="form-label">จังหวัด <span class="text-red-500">*</span></label>
                        <select id="province_select" required class="form-input"><option value="">-- เลือกจังหวัด --</option></select>
                    </div>
                    <div>
                        <label class="form-label">อำเภอ / เขต <span class="text-red-500">*</span></label>
                        <select id="district_select" required disabled class="form-input"><option value="">-- เลือกอำเภอ / เขต --</option></select>
                    </div>
                    <div>
                        <label class="form-label">ตำบล / แขวง <span class="text-red-500">*</span></label>
                        <select id="subdistrict_select" required disabled class="form-input"><option value="">-- เลือกตำบล / แขวง --</option></select>
                    </div>
                    <div>
                        <label class="form-label">รหัสไปรษณีย์ <span class="text-red-500">*</span></label>
                        <input type="text" id="zipcode_input" required readonly class="form-input bg-gray-50">
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 text-sm" style="gap: 28px 24px; margin-top: 28px;">
                    <div>
                        <label class="form-label">เลขที่ <span class="text-red-500">*</span></label>
                        <input type="text" id="ship_addr_no" required class="form-input">
                    </div>
                    <div>
                        <label class="form-label">ชั้นที่</label>
                        <input type="text" id="ship_floor" class="form-input">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="form-label">ชื่ออาคาร</label>
                        <input type="text" id="ship_building" class="form-input">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 text-sm" style="gap: 28px 24px; margin-top: 28px;">
                    <div>
                        <label class="form-label">หมู่</label>
                        <input type="text" id="ship_moo" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">หมู่บ้าน</label>
                        <input type="text" id="ship_village" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">ซอย</label>
                        <input type="text" id="ship_soi" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">ถนน</label>
                        <input type="text" id="ship_road" class="form-input">
                    </div>
                </div>

                <div class="mt-4 text-sm">
                    <label class="form-label">ข้อความเพิ่มเติม <span class="text-xs text-gray-400 font-normal">กรุณาระบุข้อมูล หรือข้อความ ตามที่ท่านต้องการ กรณีไม่มีข้อมูลให้เว้นว่างไว้ไม่ต้องใส่ - (ขีด)</span></label>
                    <textarea id="ship_note" rows="4" class="form-input"></textarea>
                </div>

                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 pt-6">
                    <button type="button" onclick="backFromStep3()" class="w-full sm:w-auto px-6 py-2.5 bg-[#004998] hover:bg-[#003774] text-white font-semibold rounded text-sm">ย้อนกลับ</button>
                    <button type="submit" class="w-full sm:w-auto px-8 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded text-sm">สร้างใบเสนอราคา</button>
                </div>
            </div>

        </form>
    </div>
</div>

<!-- Scroll to Top Button -->
<button id="scroll-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})" class="fixed bottom-6 right-6 z-50 w-10 h-10 bg-[#004998] text-white rounded-full shadow-lg flex items-center justify-center hover:bg-[#003774] transition-all opacity-0 pointer-events-none" aria-label="กลับด้านบน">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
</button>

<style>
    /* ---- Form Input (match reference design) ---- */
    .form-input {
        width: 100%;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 10px 14px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-size: 14px;
        height: 42px;
        color: #333;
    }
    .form-input::placeholder {
        color: #aaa;
    }
    textarea.form-input {
        height: 100px;
        resize: vertical;
    }
    .form-input:focus {
        border-color: #004998;
        box-shadow: 0 0 0 2px rgba(0,73,152,0.1);
        background: #fff;
    }
    .form-input.input-error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    /* ---- Labels ---- */
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #555;
        margin-bottom: 6px;
    }
    .form-label .text-red-500 {
        color: #ef4444;
        font-weight: 400;
    }

    /* ---- Section Headers ---- */
    .section-title {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    /* ---- Custom Select Dropdown ---- */
    select.form-input { display: none; }
    .cs-wrap {
        position: relative;
        width: 100%;
    }
    .cs-trigger {
        width: 100%;
        background: #f5f5f5;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 10px 36px 10px 14px;
        font-size: 14px;
        height: 42px;
        color: #333;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        transition: border-color 0.2s;
    }
    .cs-trigger::after {
        content: '';
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid #999;
    }
    .cs-trigger.open {
        border-color: #004998;
        background: #fff;
        border-radius: 6px 6px 0 0;
    }
    .cs-trigger.open::after {
        border-top: none;
        border-bottom: 6px solid #004998;
    }
    .cs-trigger.disabled {
        opacity: 0.5;
        pointer-events: none;
        background: #eee;
    }
    .cs-trigger.input-error {
        border-color: #ef4444;
        background: #fef2f2;
    }
    .cs-dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #004998;
        border-top: none;
        border-radius: 0 0 6px 6px;
        max-height: 220px;
        overflow-y: auto;
        z-index: 999;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .cs-dropdown.open {
        display: block;
    }
    .cs-option {
        padding: 9px 14px;
        cursor: pointer;
        font-size: 13px;
        color: #333;
        transition: background 0.1s;
    }
    .cs-option:hover {
        background: #EBF2FA;
    }
    .cs-option.selected {
        background: #004998;
        color: #fff;
    }
    .cs-option.placeholder {
        color: #999;
    }

    /* ---- Tax Cards ---- */
    .tax-card {
        border-color: #e5e7eb;
        background: #fff;
        border-radius: 8px;
    }
    .tax-card.active {
        border-color: #004998;
        background: #EBF2FA;
    }
    .tax-dot {
        width: 22px; height: 22px;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .tax-card.active .tax-dot {
        background: #004998;
        border-color: #004998;
    }
    .tax-card.active .tax-dot::after {
        content: '✓';
        color: #fff;
        font-size: 12px;
        font-weight: bold;
    }

    /* ---- Validation ---- */
    .validation-msg {
        color: #ef4444;
        font-size: 11px;
        margin-top: 4px;
    }

    /* ---- Step Padding ---- */
    #step-2, #step-3 {
        padding-bottom: 100px;
    }
</style>

@push('scripts')
<script src="{{ asset('js/thai-address.js') }}?v={{ time() }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    initThaiAddressSelector('province_select', 'district_select', 'subdistrict_select', 'zipcode_input');
    initThaiAddressSelector('tax_province_select', 'tax_district_select', 'tax_subdistrict_select', 'tax_zipcode_input');

    // ---- Upgrade all selects to custom dropdowns ----
    function upgradeSelect(sel) {
        if (sel.dataset.upgraded) return;
        sel.dataset.upgraded = '1';

        const wrap = document.createElement('div');
        wrap.className = 'cs-wrap';
        sel.parentNode.insertBefore(wrap, sel);
        wrap.appendChild(sel);

        const trigger = document.createElement('div');
        trigger.className = 'cs-trigger' + (sel.disabled ? ' disabled' : '');
        trigger.textContent = sel.options[sel.selectedIndex]?.text || '';

        const dropdown = document.createElement('div');
        dropdown.className = 'cs-dropdown';

        wrap.insertBefore(trigger, sel);
        wrap.appendChild(dropdown);

        function buildOptions() {
            dropdown.innerHTML = '';
            Array.from(sel.options).forEach((opt, i) => {
                const div = document.createElement('div');
                div.className = 'cs-option' + (i === 0 && !opt.value ? ' placeholder' : '') + (opt.selected && opt.value ? ' selected' : '');
                div.textContent = opt.text;
                div.dataset.value = opt.value;
                div.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sel.value = this.dataset.value;
                    sel.dispatchEvent(new Event('change'));
                    trigger.textContent = this.textContent;
                    trigger.classList.remove('open');
                    dropdown.classList.remove('open');
                    dropdown.querySelectorAll('.cs-option').forEach(o => o.classList.remove('selected'));
                    if (this.dataset.value) this.classList.add('selected');
                });
                dropdown.appendChild(div);
            });
        }
        buildOptions();

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (sel.disabled) return;
            // Close all other dropdowns
            document.querySelectorAll('.cs-trigger.open').forEach(t => {
                if (t !== trigger) { t.classList.remove('open'); t.nextElementSibling?.nextElementSibling?.classList.remove('open'); }
            });
            document.querySelectorAll('.cs-dropdown.open').forEach(d => {
                if (d !== dropdown) d.classList.remove('open');
            });
            const isOpen = trigger.classList.toggle('open');
            dropdown.classList.toggle('open', isOpen);
            // Scroll selected item into view
            if (isOpen) {
                const selected = dropdown.querySelector('.cs-option.selected');
                if (selected) selected.scrollIntoView({ block: 'nearest' });
            }
        });

        // Watch for disabled state and options changes
        const observer = new MutationObserver(() => {
            trigger.classList.toggle('disabled', sel.disabled);
            trigger.textContent = sel.options[sel.selectedIndex]?.text || '';
            buildOptions();
        });
        observer.observe(sel, { childList: true, attributes: true, attributeFilter: ['disabled'] });

        // Listen to programmatic changes
        sel.addEventListener('change', () => {
            trigger.textContent = sel.options[sel.selectedIndex]?.text || '';
            buildOptions();
        });
    }

    // Close all dropdowns on outside click
    document.addEventListener('click', function() {
        document.querySelectorAll('.cs-trigger.open').forEach(t => t.classList.remove('open'));
        document.querySelectorAll('.cs-dropdown.open').forEach(d => d.classList.remove('open'));
    });

    // Upgrade all select.form-input elements
    document.querySelectorAll('#quotation-form select.form-input').forEach(upgradeSelect);

    // Simple validation on blur
    document.querySelectorAll('#quotation-form .form-input[required]').forEach(el => {
        el.addEventListener('blur', () => simpleValidate(el));
        el.addEventListener('input', () => { if (el.classList.contains('input-error')) simpleValidate(el); });
        if (el.tagName === 'SELECT') el.addEventListener('change', () => simpleValidate(el));
    });

    // Build address on submit
    document.getElementById('quotation-form').addEventListener('submit', function(e) {
        // Validate step 3
        let valid = true;
        document.querySelectorAll('#step-3 .form-input[required]').forEach(el => {
            if (!simpleValidate(el)) valid = false;
        });
        if (!valid) { e.preventDefault(); return; }

        // Build shipping address
        const parts = [
            v('ship_addr_no'),
            v('ship_building') ? v('ship_building') : '',
            v('ship_floor') ? 'ชั้น ' + v('ship_floor') : '',
            v('ship_moo') ? 'หมู่ ' + v('ship_moo') : '',
            v('ship_village') ? 'หมู่บ้าน ' + v('ship_village') : '',
            v('ship_soi') ? 'ซอย ' + v('ship_soi') : '',
            v('ship_road') ? 'ถนน ' + v('ship_road') : '',
            v('subdistrict_select') ? 'ตำบล/แขวง ' + v('subdistrict_select') : '',
            v('district_select') ? 'อำเภอ/เขต ' + v('district_select') : '',
            v('province_select') ? 'จังหวัด ' + v('province_select') : '',
            v('zipcode_input')
        ].filter(Boolean).join(' ');
        document.getElementById('full-address-input').value = parts;

        // Build tax address
        if (document.getElementById('tax_invoice_type').value === 'paper') {
            const tp = [
                v('tax_addr_no'),
                v('tax_building') ? v('tax_building') : '',
                v('tax_floor') ? 'ชั้น ' + v('tax_floor') : '',
                v('tax_moo') ? 'หมู่ ' + v('tax_moo') : '',
                v('tax_village') ? 'หมู่บ้าน ' + v('tax_village') : '',
                v('tax_soi') ? 'ซอย ' + v('tax_soi') : '',
                v('tax_road') ? 'ถนน ' + v('tax_road') : '',
                v('tax_subdistrict_select') ? 'ตำบล/แขวง ' + v('tax_subdistrict_select') : '',
                v('tax_district_select') ? 'อำเภอ/เขต ' + v('tax_district_select') : '',
                v('tax_province_select') ? 'จังหวัด ' + v('tax_province_select') : ''
            ].filter(Boolean).join(' ');
            document.getElementById('full-tax-address-input').value = tp;
        }
    });
});

function v(id) {
    const el = document.getElementById(id);
    return el ? el.value.trim() : '';
}

// ---- Simple Validation (formal, no effects) ----
function simpleValidate(el) {
    const val = el.value.trim();
    const name = (el.name || el.id || '').toLowerCase();
    let msg = '';

    if (el.hasAttribute('required') && !val) {
        const label = el.closest('div')?.querySelector('label');
        const field = label ? label.textContent.replace(/\s*\*\s*$/, '').trim() : 'ข้อมูล';
        msg = 'กรุณากรอก' + field;
    } else if (val) {
        if (el.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) msg = 'รูปแบบอีเมลไม่ถูกต้อง';
        else if ((name.includes('phone') || el.type === 'tel') && !/^[0-9\-\s]{9,12}$/.test(val)) msg = 'กรุณาระบุเบอร์โทรศัพท์ 9-10 หลัก';
        else if (name.includes('tax_id') && !/^[0-9]{13}$/.test(val)) msg = 'เลขผู้เสียภาษีต้องมี 13 หลัก';
    }

    // Apply error to element (and to custom trigger if it's a select)
    const wrapper = el.closest('.cs-wrap');
    const errorTarget = wrapper ? wrapper.querySelector('.cs-trigger') : el;
    let feedback = (wrapper || el.parentElement).querySelector('.validation-msg');
    if (msg) {
        errorTarget.classList.add('input-error');
        if (!feedback) { feedback = document.createElement('div'); feedback.className = 'validation-msg'; (wrapper || el.parentElement).appendChild(feedback); }
        feedback.textContent = msg;
        return false;
    } else {
        errorTarget.classList.remove('input-error');
        if (feedback) feedback.remove();
        return true;
    }
}

// ---- Tax Type ----
function selectTaxType(type) {
    document.getElementById('tax_invoice_type').value = type;
    document.getElementById('tax-opt-none').classList.toggle('active', type === 'none');
    document.getElementById('tax-opt-paper').classList.toggle('active', type === 'paper');
}

function toggleBranch() {
    const corp = document.querySelector('input[name="tax_person_type"][value="corporate"]').checked;
    const row = document.getElementById('tax-branch-row');
    row.classList.toggle('hidden', !corp);
    const inp = row.querySelector('input');
    if (corp) inp.setAttribute('required', ''); else inp.removeAttribute('required');
}

// ---- Step Navigation ----
function goTo(stepId) {
    document.querySelectorAll('#step-1, #step-2, #step-3').forEach(s => s.classList.add('hidden'));
    document.getElementById(stepId).classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextFromStep1() {
    const type = document.getElementById('tax_invoice_type').value;
    if (type === 'paper') {
        goTo('step-2');
    } else {
        goTo('step-3');
    }
}

function nextFromStep2() {
    // Validate step 2 required fields
    let valid = true;
    document.querySelectorAll('#step-2 .form-input[required]').forEach(el => {
        if (!simpleValidate(el)) valid = false;
    });
    if (!valid) {
        const first = document.querySelector('#step-2 .input-error');
        if (first) { first.focus(); first.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
        return;
    }
    goTo('step-3');
}

function backFromStep3() {
    const type = document.getElementById('tax_invoice_type').value;
    goTo(type === 'paper' ? 'step-2' : 'step-1');
}

// Scroll to top button show/hide
window.addEventListener('scroll', function() {
    const btn = document.getElementById('scroll-top-btn');
    if (window.scrollY > 200) {
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
    } else {
        btn.style.opacity = '0';
        btn.style.pointerEvents = 'none';
    }
});
</script>
@endpush
</x-app-layout>
