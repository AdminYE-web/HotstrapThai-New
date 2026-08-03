<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Get session-based cart.
     */
    private function getCart(Request $request): ?Cart
    {
        $sessionId = $request->cookie('cart_session_id');
        if (!$sessionId) return null;
        return Cart::where('session_id', $sessionId)->first();
    }

    /**
     * Show Quotation Request Form.
     */
    public function create(Request $request)
    {
        $cart = $this->getCart($request);

        if (!$cart || $cart->selected_total_count === 0) {
            return redirect()->route('cart.index')->with('warning', 'กรุณาเลือกรายการสินค้าในตะกร้าก่อนขอใบเสนอราคา');
        }

        $items = $cart->items()->where('is_selected', true)->get();

        return view('quotation.create', compact('cart', 'items'));
    }

    /**
     * Store Quotation and Generate Official Quotation Document.
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:50',
            'email'         => 'required|email|max:255',
            'address'       => 'required|string',
            'tax_invoice_type' => 'required|in:none,paper',
            'note'          => 'nullable|string|max:2000',
        ];

        // Conditional validation for paper tax invoice
        if ($request->input('tax_invoice_type') === 'paper') {
            $rules['tax_person_type'] = 'required|in:individual,corporate';
            $rules['tax_name']       = 'required|string|max:255';
            $rules['tax_phone']      = 'required|string|max:50';
            $rules['tax_id']         = 'required|string|max:50';
            $rules['tax_address']    = 'required|string';

            if ($request->input('tax_person_type') === 'corporate') {
                $rules['tax_branch'] = 'required|string|max:255';
            }
        }

        $request->validate($rules);

        $cart = $this->getCart($request);

        if (!$cart || $cart->selected_total_count === 0) {
            return redirect()->route('cart.index')->with('error', 'ไม่มีรายการสินค้าในตะกร้า');
        }

        $selectedItems = $cart->items()->where('is_selected', true)->get();

        // Calculate Subtotal & Totals
        $subtotal = $selectedItems->sum(fn($item) => $item->row_total);
        
        // Get shipping fee from database
        $activeShipping = \App\Models\ShippingRate::where('is_active', true)->first();
        $shippingFee = $activeShipping ? (float) $activeShipping->cost : 0.00;
        
        $vatAmount = round(($subtotal + $shippingFee) * 0.07, 2); // VAT 7%
        $grandTotal = $subtotal + $shippingFee + $vatAmount;

        // Generate Quotation No (e.g., HS-T-20260723_0001)
        $dateStr = now()->format('Ymd');
        $lastQuote = Quotation::whereDate('created_at', now()->toDateString())->latest()->first();
        $sequence = $lastQuote ? ((int) substr($lastQuote->quotation_no, -4)) + 1 : 1;
        $quotationNo = 'HS-T-' . $dateStr . '_' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Create Quotation Record
        $quotation = Quotation::create([
            'quotation_no'      => $quotationNo,
            'customer_name'     => $request->input('customer_name'),
            'company_name'      => $request->input('company_name'),
            'phone'             => $request->input('phone'),
            'email'             => $request->input('email'),
            'tax_id'            => $request->input('tax_id'),
            'address'           => $request->input('address'),
            'tax_invoice_type'  => $request->input('tax_invoice_type', 'none'),
            'tax_person_type'   => $request->input('tax_person_type'),
            'tax_name'          => $request->input('tax_name'),
            'tax_phone'         => $request->input('tax_phone'),
            'tax_branch'        => $request->input('tax_branch'),
            'tax_address'       => $request->input('tax_address'),
            'note'              => $request->input('note'),
            'subtotal'          => $subtotal,
            'shipping_fee'      => $shippingFee,
            'vat_amount'        => $vatAmount,
            'grand_total'       => $grandTotal,
            'status'            => 'pending',
        ]);

        // Create Quotation Items
        foreach ($selectedItems as $item) {
            if (!empty($item->custom_data) && isset($item->custom_data['line_items'])) {
                // It's a custom product with detailed breakdown
                $first = true;
                foreach ($item->custom_data['line_items'] as $line) {
                    QuotationItem::create([
                        'quotation_id'     => $quotation->id,
                        'product_id'       => $first ? $item->product_id : null,
                        'product_name'     => $line['item'],
                        'quantity'         => $line['qty'],
                        'unit_price'       => $line['unit_cost'],
                        // Store the full options snapshot only on the first item (main product)
                        'options_snapshot' => $first ? $item->options_snapshot : null,
                        'is_preorder'      => $item->is_preorder,
                        'lead_time'        => $first ? $item->lead_time : null,
                        'row_total'        => $line['total'],
                    ]);
                    $first = false;
                }
            } else {
                QuotationItem::create([
                    'quotation_id'     => $quotation->id,
                    'product_id'       => $item->product_id,
                    'product_name'     => $item->product_name,
                    'quantity'         => $item->quantity,
                    'unit_price'       => $item->unit_price,
                    'options_snapshot' => $item->options_snapshot,
                    'is_preorder'      => $item->is_preorder,
                    'lead_time'        => $item->lead_time,
                    'row_total'        => $item->unit_price * $item->quantity,
                ]);
            }
        }

        // Clear selected items from cart
        $cart->items()->where('is_selected', true)->delete();

        // --- Create Order for Order Management Data Integration ---
        $dateStr = now()->format('Ymd');
        $lastOrder = \App\Models\Order::whereDate('created_at', now()->toDateString())->latest()->first();
        $orderSequence = $lastOrder ? ((int) substr($lastOrder->order_no, -4)) + 1 : 1;
        $orderNo = 'ORD-' . $dateStr . '-' . str_pad($orderSequence, 4, '0', STR_PAD_LEFT);

        $order = \App\Models\Order::create([
            'order_no' => $orderNo,
            'quotation_id' => $quotation->id,
            'customer_name' => $quotation->customer_name,
            'company_name' => $quotation->company_name,
            'phone' => $quotation->phone,
            'email' => $quotation->email,
            'address' => $quotation->address,
            'tax_invoice_type' => $quotation->tax_invoice_type,
            'tax_person_type' => $quotation->tax_person_type,
            'tax_id' => $quotation->tax_id,
            'tax_name' => $quotation->tax_name,
            'tax_phone' => $quotation->tax_phone,
            'tax_branch' => $quotation->tax_branch,
            'tax_address' => $quotation->tax_address,
            'subtotal' => $quotation->subtotal,
            'shipping_fee' => $quotation->shipping_fee,
            'vat_amount' => $quotation->vat_amount,
            'grand_total' => $quotation->grand_total,
            'payment_method' => 'bank_transfer',
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);
        // ------------------------------------------------------------

        return redirect()->route('quotation.show', $quotation->id)
            ->with('success', 'สร้างใบเสนอราคาเรียบร้อยแล้ว');
    }

    /**
     * Display Official Printable Quotation Document.
     */
    public function show($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        return view('quotation.show', compact('quotation'));
    }
}
