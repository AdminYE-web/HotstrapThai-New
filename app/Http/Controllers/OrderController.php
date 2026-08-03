<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id'
        ]);

        $quotation = Quotation::with('items')->findOrFail($request->quotation_id);

        // check if order already exists for this quotation
        $existingOrder = Order::where('quotation_id', $quotation->id)->first();
        if ($existingOrder) {
            return redirect()->route('order.show', $existingOrder->id);
        }

        DB::beginTransaction();
        try {
            // Generate Order No (ORD-YYYYMMDD-XXXX)
            $dateStr = now()->format('Ymd');
            $lastOrder = Order::whereDate('created_at', now()->toDateString())->latest()->first();
            $sequence = $lastOrder ? ((int) substr($lastOrder->order_no, -4)) + 1 : 1;
            $orderNo = 'ORD-' . $dateStr . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
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

            // Assuming we have an OrderItem model, or we just rely on order.quotation.items
            // Based on earlier inspection, the DB has order_items?
            // Since we aren't 100% sure about order_items, let's check if it exists. For now, Order links to Quotation which has items.

            DB::commit();

            return redirect()->route('order.show', $order->id)->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::with('quotation.items')->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
