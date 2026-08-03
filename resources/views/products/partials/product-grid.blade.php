@forelse ($products as $product)
    @include('products.partials.product-card', ['product' => $product])
@empty
    <div class="empty-state" style="grid-column:1/-1;">
        <div class="empty-icon">🔍</div>
        <h3 class="empty-title">ไม่พบสินค้าที่ตรงตามเงื่อนไขที่เลือก</h3>
        <p class="empty-desc">ลองเปลี่ยนเงื่อนไขการกรองหรือล้างตัวกรองทั้งหมด</p>
        <button class="empty-reset-btn" onclick="resetFilters()">ล้างตัวกรองทั้งหมด</button>
    </div>
@endforelse
