<x-app-layout>
@push('styles')
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">
<link rel="stylesheet" href="{{ asset('css/products-index.css') }}">
@endpush

<div class="cart-page-bg">
    <div class="cart-container">
        
        @if($cart->items->isEmpty())
            {{-- Empty Cart State (Matching Design Screenshot) --}}
            <div class="empty-cart-wrapper text-center py-12">
                <h1 class="text-xl font-bold text-gray-900 mb-8">ตะกร้าสินค้า</h1>
                
                {{-- Shopping Cart Graphic --}}
                <div class="mx-auto mb-6 flex justify-center">
                    <svg width="240" height="200" viewBox="0 0 240 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Handle & Outer Frame -->
                        <path d="M25 35H55L80 125H180L205 60H62" stroke="#B0B7C3" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
                        <!-- Wheels -->
                        <circle cx="90" cy="155" r="18" fill="#B0B7C3"/>
                        <circle cx="90" cy="155" r="7" fill="#FFFFFF"/>
                        <circle cx="170" cy="155" r="18" fill="#B0B7C3"/>
                        <circle cx="170" cy="155" r="7" fill="#FFFFFF"/>
                    </svg>
                </div>

                <p class="text-base font-bold text-gray-900 mb-8">ยังไม่มีสินค้าในตะกร้าของคุณ</p>

                <a href="{{ route('products.index') }}" class="btn-empty-shop">
                    เลือกซื้อสินค้า
                </a>
            </div>

            {{-- Recommended Products Section --}}
            <div class="mt-8 mb-4">
                <x-recommended-products />
            </div>
        @else

            {{-- Page Header --}}
            <div class="mb-6">
                <h1 class="cart-header-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>ตะกร้าสินค้า</span>
                    <span class="cart-header-count">({{ $cart->items->count() }} รายการ)</span>
                </h1>
                <p class="cart-header-sub">ตรวจสอบรายการสินค้าและขอใบเสนอราคาเพื่อดำเนินการสั่งซื้อ</p>
            </div>

            {{-- Main Layout (2 Columns: Left Item List, Right Summary) --}}
            <div class="cart-grid-layout">

                {{-- Left Side: Item List (Class cart-left-col) --}}
                <div class="cart-left-col">
                    
                    {{-- ══════════════════════════════════════════════
                         SECTION 1: สินค้าพร้อมส่ง
                    ══════════════════════════════════════════════ --}}
                    <div class="mb-8">
                        <div class="cart-section-head">
                            <input type="checkbox" 
                                   class="custom-chk" 
                                   id="chk-group-ready"
                                   {{ $readyItems->count() > 0 && $readyItems->where('is_selected', true)->count() === $readyItems->count() ? 'checked' : '' }}
                                   onchange="toggleGroupSelect('ready', this.checked)">
                            <span class="text-emerald-600 font-bold flex items-center gap-2">
                                <img src="{{ asset('images/icons/icon-ready-box.png') }}" class="w-5 h-5 object-contain inline-block mr-2" alt="สินค้าพร้อมส่ง" />
                                สินค้าพร้อมส่ง
                            </span>
                            <span class="text-gray-500 font-normal text-sm">({{ $readyItems->count() }} รายการ)</span>
                        </div>

                        @forelse($readyItems as $item)
                            <div class="cart-card" id="cart-item-{{ $item->id }}">
                                <input type="checkbox" 
                                       class="custom-chk" 
                                       id="chk-item-{{ $item->id }}"
                                       {{ $item->is_selected ? 'checked' : '' }}
                                       onchange="toggleItemSelect({{ $item->id }})">

                                <img src="{{ asset($item->image_url ?? 'images/products/lanyard-fancy-clip.png') }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="cart-card-img">

                                <div class="cart-card-body">
                                    <div class="cart-card-head">
                                        <div>
                                            <h3 class="cart-card-title">{{ $item->product_name }}</h3>
                                            <div class="badge-ready-pill">
                                                <img src="{{ asset('images/icons/icon-ready-box.png') }}" class="w-3.5 h-3.5 object-contain inline-block mr-1" alt="พร้อมส่ง" />
                                                <span>พร้อมส่ง</span>
                                                <span class="badge-leadtime">{{ $item->lead_time ?? '1-3 วันทำการ' }}</span>
                                            </div>
                                        </div>
                                        <button class="btn-delete-item" 
                                                type="button"
                                                onclick="confirmDeleteItem({{ $item->id }})" 
                                                title="ลบรายการนี้">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>

                                    @if(!empty($item->options_snapshot))
                                        <div class="cart-specs-box">
                                            {{ implode(' > ', $item->options_snapshot) }}
                                        </div>
                                    @endif

                                    <div class="cart-card-bottom">
                                        <div class="qty-control">
                                            <button type="button" class="btn-qty" onclick="changeQty({{ $item->id }}, -1)">-</button>
                                            <input type="number" 
                                                   id="input-qty-{{ $item->id }}"
                                                   class="input-qty" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1"
                                                   onchange="onQtyInputChange({{ $item->id }}, this.value)">
                                            <button type="button" class="btn-qty" onclick="changeQty({{ $item->id }}, 1)">+</button>
                                        </div>

                                        <div class="price-box">
                                            <div class="unit-price">฿ {{ number_format($item->unit_price, 2) }}</div>
                                            <div class="total-price" id="row-total-{{ $item->id }}">฿ {{ number_format($item->row_total, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-xl border border-gray-200 p-6 text-center text-gray-400 text-sm">
                                ไม่มีสินค้าพร้อมส่งในตะกร้า
                            </div>
                        @endforelse
                    </div>

                    {{-- ══════════════════════════════════════════════
                         SECTION 2: สินค้าพรีออเดอร์
                    ══════════════════════════════════════════════ --}}
                    <div>
                        <div class="cart-section-head">
                            <input type="checkbox" 
                                   class="custom-chk" 
                                   id="chk-group-preorder"
                                   {{ $preorderItems->count() > 0 && $preorderItems->where('is_selected', true)->count() === $preorderItems->count() ? 'checked' : '' }}
                                   onchange="toggleGroupSelect('preorder', this.checked)">
                            <span class="text-orange-600 font-bold flex items-center gap-2">
                                <img src="{{ asset('images/icons/icon-preorder-clock.png') }}" class="w-5 h-5 object-contain inline-block mr-2" alt="สินค้าที่ต้องรอพรีออเดอร์" />
                                สินค้าที่ต้องรอพรีออเดอร์
                            </span>
                            <span class="text-gray-500 font-normal text-sm">({{ $preorderItems->count() }} รายการ)</span>
                        </div>

                        @forelse($preorderItems as $item)
                            <div class="cart-card" id="cart-item-{{ $item->id }}">
                                <input type="checkbox" 
                                       class="custom-chk" 
                                       id="chk-item-{{ $item->id }}"
                                       {{ $item->is_selected ? 'checked' : '' }}
                                       onchange="toggleItemSelect({{ $item->id }})">

                                <img src="{{ asset($item->image_url ?? 'images/products/lanyard-polyester-blue.png') }}" 
                                     alt="{{ $item->product_name }}" 
                                     class="cart-card-img">

                                <div class="cart-card-body">
                                    <div class="cart-card-head">
                                        <div>
                                            <h3 class="cart-card-title">{{ $item->product_name }}</h3>
                                            <div class="badge-preorder-pill">
                                                <img src="{{ asset('images/icons/icon-preorder-clock.png') }}" class="w-3.5 h-3.5 object-contain inline-block mr-1" alt="พรีออเดอร์" />
                                                <span>พรีออเดอร์</span>
                                                <span class="badge-leadtime">{{ $item->lead_time ?? '14-21 วันทำการ' }}</span>
                                            </div>
                                        </div>

                                        <div class="cart-card-actions">
                                            @if($item->product_id)
                                                @php
                                                    $editRoute = !empty($item->custom_data) 
                                                        ? route('products.customize', ['slug' => $item->product?->slug ?? $item->product_id, 'cart_item' => $item->id])
                                                        : route('products.show', $item->product?->slug ?? $item->product_id);
                                                @endphp
                                                <a href="{{ $editRoute }}" class="btn-edit-spec" title="แก้ไขสเปก">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                                    </svg>
                                                    <span>แก้ไข</span>
                                                </a>
                                            @endif
                                            <button class="btn-delete-item" 
                                                    type="button"
                                                    onclick="confirmDeleteItem({{ $item->id }})" 
                                                    title="ลบรายการนี้">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    @if(!empty($item->options_snapshot))
                                        <div class="cart-specs-box">
                                            {{ implode(' > ', $item->options_snapshot) }}
                                        </div>
                                    @endif

                                    <div class="cart-card-bottom">
                                        @if(!empty($item->custom_data))
                                            <div class="qty-control" style="background: none; border: none; padding-left: 0;">
                                                <span class="text-sm font-bold text-gray-700">จำนวน: {{ $item->quantity }} เส้น</span>
                                            </div>
                                        @else
                                            <div class="qty-control">
                                                <button type="button" class="btn-qty" onclick="changeQty({{ $item->id }}, -1)">-</button>
                                                <input type="number" 
                                                       id="input-qty-{{ $item->id }}"
                                                       class="input-qty" 
                                                       value="{{ $item->quantity }}" 
                                                       min="1"
                                                       onchange="onQtyInputChange({{ $item->id }}, this.value)">
                                                <button type="button" class="btn-qty" onclick="changeQty({{ $item->id }}, 1)">+</button>
                                            </div>
                                        @endif

                                        <div class="price-box">
                                            @if(!empty($item->custom_data))
                                            <div class="unit-price" style="font-size:11px;">(ดูราคาแยกในใบเสนอราคา)</div>
                                            @else
                                            <div class="unit-price">฿ {{ number_format($item->unit_price, 2) }}</div>
                                            @endif
                                            <div class="total-price" id="row-total-{{ $item->id }}">฿ {{ number_format($item->row_total, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white rounded-xl border border-gray-200 p-6 text-center text-gray-400 text-sm">
                                ไม่มีสินค้าพรีออเดอร์ในตะกร้า
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Right Side: Order Summary Sidebar (Class cart-right-col) --}}
                <div class="cart-right-col">
                    <div class="summary-card">
                        <h2 class="summary-title">สรุปรายการ</h2>

                        <div class="summary-row">
                            <span>สินค้าพร้อมส่ง</span>
                            <span id="summary-ready-count">{{ $cart->selected_ready_count }} รายการ</span>
                        </div>

                        <div class="summary-row">
                            <span>สินค้าพรีออเดอร์</span>
                            <span id="summary-preorder-count">{{ $cart->selected_preorder_count }} รายการ</span>
                        </div>

                        <div class="summary-divider"></div>

                        <div class="summary-row">
                            <span>จำนวนรายการ</span>
                            <span id="summary-total-count" class="font-bold text-gray-900">{{ $cart->selected_total_count }} รายการ</span>
                        </div>

                        <div class="summary-grand-row">
                            <span>ราคาสุทธิ</span>
                            <span id="summary-grand-total" class="summary-grand-price">฿ {{ number_format($cart->grand_total, 2) }}</span>
                        </div>

                        {{-- Action Buttons --}}
                        <a href="{{ route('quotation') }}" 
                           id="btn-request-quote"
                           class="btn-summary-primary {{ $cart->selected_total_count > 0 ? 'active' : '' }}">
                            ขอใบเสนอราคา
                        </a>

                        <a href="{{ route('products.index') }}" class="btn-summary-secondary">
                            เลือกดูสินค้าเพิ่มเติม
                        </a>

                        {{-- Callout Box 1: Orange Notice --}}
                        <div class="notice-box-orange">
                            <strong>หมายเหตุ:</strong> ใบเสนอราคาที่จัดทำโดยระบบอัตโนมัติ เพื่อเป็นการอ้างอิงราคาเบื้องต้นเท่านั้น กรุณาติดต่อฝ่ายขายเพื่อยืนยันข้อมูลการสั่งซื้อและราคาอย่างเป็นทางการ
                        </div>

                        {{-- Callout Box 2: Blue Steps --}}
                        <div class="steps-box-blue">
                            <div class="steps-title">ขั้นตอนการสั่งซื้อ</div>
                            <ol class="steps-list">
                                <li>กรอกข้อมูลเพื่อขอใบเสนอราคา</li>
                                <li>รอรับใบเสนอราคาโดยระบบอัตโนมัติ</li>
                                <li>ติดต่อฝ่ายขายเพื่อยืนยันการสั่งซื้อ</li>
                            </ol>
                        </div>

                        {{-- Delivery info footer badges --}}
                        <div class="delivery-info-list">
                            <div class="delivery-info-item">
                                <img src="{{ asset('images/icons/icon-ready-box.png') }}" class="w-4 h-4 object-contain inline-block mr-1.5" alt="" />
                                <span>สินค้าพร้อมส่งจัดส่งภายใน 1-3 วันทำการ</span>
                            </div>
                            <div class="delivery-info-item">
                                <img src="{{ asset('images/icons/icon-preorder-clock.png') }}" class="w-4 h-4 object-contain inline-block mr-1.5" alt="" />
                                <span>สินค้าพรีออเดอร์ใช้เวลาผลิตตามที่ระบุ</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        @endif

    </div>
</div>

@push('scripts')
{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const CSRF_TOKEN = '{{ csrf_token() }}';

function changeQty(itemId, delta) {
    const input = document.getElementById('input-qty-' + itemId);
    if (!input) return;
    const currentQty = parseInt(input.value) || 1;
    const newQty = Math.max(1, currentQty + delta);
    input.value = newQty;
    updateQtyOnServer(itemId, newQty);
}

function onQtyInputChange(itemId, val) {
    const newQty = Math.max(1, parseInt(val) || 1);
    updateQtyOnServer(itemId, newQty);
}

function updateQtyOnServer(itemId, qty) {
    fetch('{{ url("/cart/update") }}/' + itemId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: qty })
    })
    .then(res => res.json())
    .then(res => {
        if (res.requires_split) {
            // Show Stock Validation & Auto-Split Confirmation Modal
            Swal.fire({
                title: 'แจ้งเตือนสต็อกสินค้า',
                text: res.message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#004998',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmSplitOnServer(itemId, res.requested_qty);
                } else {
                    // Revert input to available stock
                    document.getElementById('input-qty-' + itemId).value = res.available_stock;
                    updateQtyOnServer(itemId, res.available_stock);
                }
            });
        } else if (res.success) {
            updateSummaryUI(res);
        }
    })
    .catch(err => console.error(err));
}

function confirmSplitOnServer(itemId, requestedQty) {
    fetch('{{ url("/cart/confirm-split") }}/' + itemId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ requested_qty: requestedQty })
    })
    .then(res => res.json())
    .then(res => {
        if (res.reload) window.location.reload();
    });
}

function toggleItemSelect(itemId) {
    fetch('{{ url("/cart/toggle-select") }}/' + itemId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) updateSummaryUI(res);
    });
}

function toggleGroupSelect(group, selected) {
    fetch('{{ url("/cart/toggle-select") }}/' + group, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ selected: selected })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) window.location.reload();
    });
}

function confirmDeleteItem(itemId) {
    Swal.fire({
        title: 'ต้องการลบสินค้านี้ใช่หรือไม่?',
        text: 'รายการสินค้านี้จะถูกลบออกจากตะกร้าของคุณ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#9CA3AF',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ url("/cart/delete") }}/' + itemId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if (res.reload) window.location.reload();
            });
        }
    });
}

function updateSummaryUI(data) {
    const readyEl = document.getElementById('summary-ready-count');
    const preorderEl = document.getElementById('summary-preorder-count');
    const totalEl = document.getElementById('summary-total-count');
    const grandEl = document.getElementById('summary-grand-total');
    const btnQuote = document.getElementById('btn-request-quote');

    if (readyEl) readyEl.textContent = data.ready_count + ' รายการ';
    if (preorderEl) preorderEl.textContent = data.preorder_count + ' รายการ';
    if (totalEl) totalEl.textContent = data.total_count + ' รายการ';
    if (grandEl) grandEl.textContent = '฿ ' + data.grand_total;

    if (btnQuote) {
        if (data.total_count > 0) {
            btnQuote.classList.add('active');
        } else {
            btnQuote.classList.remove('active');
        }
    }
}
</script>
@endpush
</x-app-layout>
