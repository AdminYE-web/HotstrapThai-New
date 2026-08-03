<x-app-layout>
<div class="bg-gray-50 min-h-screen py-10">
    <div id="quotation-wrapper" style="width:210mm; max-width:100%; margin:0 auto; padding:0 15px;">

        <!-- Success Header -->
        <div class="text-center mb-8 no-print">
            <h1 style="font-size:22px; font-weight:bold; color:#1a1a1a;">ขอบคุณสำหรับการทำใบเสนอราคา</h1>
        </div>

        <!-- ========== Quotation Document ========== -->
        <div style="background:#fff; border:1px solid #ddd; overflow:hidden; min-height:297mm; box-sizing:border-box;" id="quotation-doc">

            <!-- Quotation Title Bar -->
            <div style="background:#1a1a1a; padding:10px 0; text-align:center;">
                <h2 style="font-size:16px; font-weight:bold; color:#fff; letter-spacing:2px; margin:0;">ใบเสนอราคา</h2>
            </div>

            <div style="padding:30px 40px;">

                <!-- Company Info + Logo -->
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
                    <div style="font-size:11px; color:#444; line-height:1.7;">
                        <p style="font-weight:bold; color:#1a1a1a; font-size:12px; margin:0;">YOU AND EARTH (THAILAND) CO., LTD.</p>
                        <p style="margin:0;">23/34-35 The Prime Hua Lamphong, Building A, 4rd Floor, Room No. 404,</p>
                        <p style="margin:0;">Soi Sukorn, Trimit Road, Talat Noi, Samphanthawong, Bangkok 10100</p>
                        <p style="margin:0;">Tel : 064-604-5614</p>
                        <p style="margin:0;">TAX ID: 010-556-3086-07-0, Head Office</p>
                    </div>
                    <div style="flex-shrink:0; margin-left:20px;">
                        <img src="{{ asset('images/logo-hotstrap-new.png') }}" alt="HOT STRAP" style="height:60px; object-fit:contain;" onerror="this.outerHTML='<div style=\'font-size:24px; font-weight:900; color:#c00;\'>HOT STRAP</div>'">
                    </div>
                </div>

                <!-- Customer Name (Editable) + Quotation Meta -->
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
                    <div style="font-size:13px; padding-top:4px;">
                        <div contenteditable="true" id="editable-name"
                             style="font-weight:bold; color:#1a1a1a; min-width:200px; outline:none; cursor:text;"
                             data-placeholder="Enter your Name.">{{ $quotation->customer_name ?: '' }}</div>
                        <div contenteditable="true" id="editable-company"
                             style="font-weight:bold; color:#1a1a1a; min-width:200px; outline:none; cursor:text; margin-top:16px;"
                             data-placeholder="Enter company detail.">{{ $quotation->company_name ?: '' }}</div>
                    </div>
                    <table style="border-collapse:collapse; font-size:11px; flex-shrink:0; margin-left:20px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding:5px 10px; background:#f0f0f0; border:1px solid #1a1a1a; width:100px;">Quotation #</td>
                            <td style="padding:5px 10px; border:1px solid #1a1a1a; width:160px; text-align:right;">{{ $quotation->quotation_no }}</td>
                        </tr>
                        <tr>
                            <td style="padding:5px 10px; background:#f0f0f0; border:1px solid #1a1a1a;">Date</td>
                            <td style="padding:5px 10px; border:1px solid #1a1a1a; text-align:right;">{{ $quotation->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td style="padding:5px 10px; background:#f0f0f0; border:1px solid #1a1a1a;">Amount Due</td>
                            <td style="padding:5px 10px; border:1px solid #1a1a1a; text-align:right;">{{ number_format($quotation->grand_total, 2) }} baht</td>
                        </tr>
                    </table>
                </div>

                <!-- Items Table -->
                <table style="width:100%; border-collapse:collapse; font-size:11px; margin-bottom:24px;">
                    <thead>
                        <tr style="background:#f0f0f0;">
                            <th style="padding:8px; text-align:left; border:1px solid #1a1a1a; font-weight:normal;">Item</th>
                            <th style="padding:8px; text-align:left; border:1px solid #1a1a1a; width:90px; font-weight:normal;">Unit Cost</th>
                            <th style="padding:8px; text-align:left; border:1px solid #1a1a1a; width:70px; font-weight:normal;">Quantity</th>
                            <th style="padding:8px; text-align:left; border:1px solid #1a1a1a; width:100px; font-weight:normal;">Price(baht)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotation->items as $item)
                        <tr>
                            <td style="padding:8px; border:1px solid #1a1a1a;">
                                <div>{{ $item->product_name }}</div>
                                @if(!empty($item->options_snapshot))
                                    <div style="font-size:10px; color:#555;">{{ is_array($item->options_snapshot) ? implode(' > ', $item->options_snapshot) : $item->options_snapshot }}</div>
                                @endif
                            </td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ number_format($item->unit_price, 0) }}</td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ $item->quantity }}</td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ number_format($item->row_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="padding:8px; border:1px solid #1a1a1a; text-align:right;">Subtotal</td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ number_format($quotation->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding:8px; border:1px solid #1a1a1a; text-align:right;">Shipping Fee</td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ number_format($quotation->shipping_fee, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding:8px; border:1px solid #1a1a1a; text-align:right;">VAT 7%</td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ number_format($quotation->vat_amount, 2) }}</td>
                        </tr>
                        <tr style="background:#f0f0f0;">
                            <td colspan="3" style="padding:8px; border:1px solid #1a1a1a; text-align:right;">Balance Due</td>
                            <td style="padding:8px; border:1px solid #1a1a1a;">{{ number_format($quotation->grand_total, 2) }} baht</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Payment Method -->
                <div style="margin-bottom:30px;">
                    <h3 style="font-size:11px; font-weight:normal; color:#1a1a1a; letter-spacing:3px; margin-bottom:10px;">P A Y M E N T &nbsp; M E T H O D</h3>
                    <table style="font-size:11px; border-collapse:collapse; width:350px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding:6px 10px; background:#f0f0f0; border:1px solid #1a1a1a; width:100px;">Bank's name</td>
                            <td style="padding:6px 10px; border:1px solid #1a1a1a;">ไทยพาณิชย์(SCB)</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 10px; background:#f0f0f0; border:1px solid #1a1a1a;">Bank number</td>
                            <td style="padding:6px 10px; border:1px solid #1a1a1a;">191-213953-5</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 10px; background:#f0f0f0; border:1px solid #1a1a1a;">Account name</td>
                            <td style="padding:6px 10px; border:1px solid #1a1a1a;">บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 10px; background:#f0f0f0; border:1px solid #1a1a1a;">Branch name</td>
                            <td style="padding:6px 10px; border:1px solid #1a1a1a;">ถนนสาทร</td>
                        </tr>
                    </table>
                </div>

                <!-- Terms -->
                <div style="margin-bottom:16px; border-top:1px solid #1a1a1a; padding-top:10px;">
                    <h3 style="font-size:11px; font-weight:normal; color:#1a1a1a; letter-spacing:3px; margin-bottom:8px; text-align:center;">T E R M S</h3>
                    <p style="font-size:10px; color:#555; line-height:1.6; text-align:center; margin:0;">
                        ราคาด้านบนเป็นราคาที่รวมค่าจัดส่งเรียบร้อยแล้ว ระยะเวลาการจัดส่งจะเป็นไปตามที่ระบุอยู่บนเว็บไซต์ หลังจากสั่งซื้อเรียบร้อยแล้วกรุณาโอนเงินภายใน 7 วัน สอบถามข้อมูลเพิ่มเติม
                        ที่ contact_hs@hotstrapthai.com
                    </p>
                </div>

            </div>
        </div>

        <!-- Action Buttons (outside document) -->
        <div style="display:flex; justify-content:flex-end; margin-top:20px;" class="no-print">
            <button onclick="printQuotation()" style="display:inline-flex; align-items:center; gap:8px; padding:10px 24px; background:#c62828; color:#fff; font-weight:600; font-size:13px; border:none; border-radius:6px; cursor:pointer; box-shadow:0 2px 6px rgba(0,0,0,0.15);">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                พิมพ์ใบเสนอราคา
            </button>
        </div>

        <div style="display:flex; flex-direction:column; align-items:center; gap:12px; margin-top:20px;" class="no-print">
            <a href="{{ route('products.index') }}" style="display:block; width:300px; padding:12px 0; background:#004998; color:#fff; font-weight:bold; font-size:14px; text-align:center; border-radius:8px; text-decoration:none;">
                กลับสู่หน้าหลัก
            </a>
            <a href="{{ route('products.index') }}" style="display:block; width:300px; padding:12px 0; background:#fff; color:#333; font-weight:600; font-size:14px; text-align:center; border-radius:8px; text-decoration:none; border:1px solid #ccc;">
                เลือกดูสินค้าเพิ่มเติม
            </a>
        </div>

    </div>
</div>

@push('styles')
<style>
    /* Editable placeholders */
    [contenteditable][data-placeholder]:empty::before {
        content: attr(data-placeholder);
        color: #999;
    }
    [contenteditable]:focus {
        background: #fffde7;
    }
    /* Print styles */
    @media print {
        header, footer, nav, .no-print,
        [class*="floating"], [class*="footer"] {
            display: none !important;
        }
        body { background: #fff !important; margin: 5mm !important; padding: 0 !important; }
        .bg-gray-50 { background: #fff !important; padding: 0 !important; min-height: auto !important; }
        #quotation-wrapper { width: 100% !important; padding: 0 !important; margin: 0 !important; }
        #quotation-doc { width: 100% !important; min-height: auto !important; box-shadow: none !important; border: none !important; }
        @page { size: A4 portrait; margin: 0; }
    }
</style>
@endpush

@push('scripts')
<script>
function printQuotation() {
    window.print();
}
</script>
@endpush
</x-app-layout>
