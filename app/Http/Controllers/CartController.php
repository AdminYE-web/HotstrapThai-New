<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Get or create session-based cart for guest users.
     */
    private function getOrCreateCart(Request $request): Cart
    {
        $sessionId = $request->cookie('cart_session_id');

        if (!$sessionId) {
            $sessionId = (string) Str::uuid();
            cookie()->queue('cart_session_id', $sessionId, 60 * 24 * 30); // 30 days
        }

        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['shipping_fee' => 0.00]
        );
    }

    /**
     * Display Shopping Cart Page.
     */
    public function index(Request $request)
    {
        $cart = $this->getOrCreateCart($request);

        // Seed demo cart items matching user design mockup if empty, unless explicitly requesting empty cart test
        // if ($cart->items()->count() === 0 && !$request->has('empty')) {
        //     $this->seedDemoCartItems($cart);
        // }

        $readyItems    = $cart->readyToShipItems()->get();
        $preorderItems = $cart->preorderItems()->get();
        
        $recommendedProducts = Product::where('is_active', true)
            ->with(['primaryImage', 'detail', 'variants'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('cart.index', compact('cart', 'readyItems', 'preorderItems', 'recommendedProducts'));
    }

    /**
     * Seed initial demo cart items using real ready_to_ship products from database.
     */
    private function seedDemoCartItems(Cart $cart)
    {
        $readyToShipQuery = fn() => Product::whereHas('detail.productType', fn($q) => $q->where('slug', 'ready_to_ship'));

        $prodPolyesterBlue = $readyToShipQuery()->where('id', 17)->first() 
            ?? $readyToShipQuery()->first();
        
        $prodIdStd = $readyToShipQuery()->where('id', 24)->first() 
            ?? $readyToShipQuery()->skip(1)->first();

        $prodYoyoBlack = $readyToShipQuery()->where('id', 67)->first() 
            ?? $readyToShipQuery()->skip(2)->first();

        $prodYoyoWhite = $readyToShipQuery()->where('id', 68)->first() 
            ?? $readyToShipQuery()->skip(3)->first();

        // 1. Ready to ship item 1
        if ($prodPolyesterBlue) {
            CartItem::create([
                'cart_id'      => $cart->id,
                'product_id'   => $prodPolyesterBlue->id,
                'product_name' => $prodPolyesterBlue->name,
                'image_url'    => $prodPolyesterBlue->primaryImage?->image_path ?? 'images/products/lanyard-polyester.png',
                'quantity'     => 8,
                'unit_price'   => $prodPolyesterBlue->base_price,
                'is_preorder'  => false,
                'lead_time'    => '1-3 วันทำการ',
                'is_selected'  => true,
            ]);
        }

        // 2. Ready to ship item 2
        if ($prodIdStd) {
            CartItem::create([
                'cart_id'      => $cart->id,
                'product_id'   => $prodIdStd->id,
                'product_name' => $prodIdStd->name,
                'image_url'    => $prodIdStd->primaryImage?->image_path ?? 'images/products/acc-badge-holder.png',
                'quantity'     => 11,
                'unit_price'   => $prodIdStd->base_price,
                'is_preorder'  => false,
                'lead_time'    => '1-3 วันทำการ',
                'is_selected'  => true,
            ]);
        }

        // 3. Preorder item 1
        if ($prodYoyoBlack) {
            CartItem::create([
                'cart_id'      => $cart->id,
                'product_id'   => $prodYoyoBlack->id,
                'product_name' => $prodYoyoBlack->name,
                'image_url'    => $prodYoyoBlack->primaryImage?->image_path ?? 'images/products/acc-yoyo.png',
                'quantity'     => 1,
                'unit_price'   => $prodYoyoBlack->base_price,
                'is_preorder'  => true,
                'lead_time'    => '14-21 วันทำการ',
                'is_selected'  => true,
            ]);
        }

        // 4. Preorder item 2 (with spec options)
        if ($prodYoyoWhite) {
            CartItem::create([
                'cart_id'          => $cart->id,
                'product_id'       => $prodYoyoWhite->id,
                'product_name'     => $prodYoyoWhite->name,
                'image_url'        => $prodYoyoWhite->primaryImage?->image_path ?? 'images/products/acc-yoyo.png',
                'quantity'         => 1,
                'unit_price'       => $prodYoyoWhite->base_price,
                'is_preorder'      => true,
                'lead_time'        => '14-21 วันทำการ',
                'is_selected'      => true,
                'options_snapshot' => [
                    '10mm',
                    'สกรีนด้านเดียว',
                    'คลิปดำ',
                    'สีFlag red,361C',
                    '200เส้น',
                    'ตัวอย่าง',
                    'แบบเร่งด่วน'
                ],
            ]);
        }
    }

    /**
     * Add product to cart (Supports ready_to_ship & custom products).
     */
    public function add(Request $request)
    {
        $cart = $this->getOrCreateCart($request);
        $productId = $request->input('product_id');
        $quantity  = max(1, (int) $request->input('quantity', 1));
        $options   = $request->input('options_snapshot', []);

        if (is_string($options)) {
            $options = json_decode($options, true) ?? [$options];
        }

        $product = Product::with(['detail', 'variants', 'primaryImage', 'prices'])->findOrFail($productId);
        $img = $product->primaryImage?->image_path ?? 'images/products/lanyard-polyester.png';

        // 1. Custom Product Flow
        if ($product->type === 'custom') {
            $customData = $request->input('custom_data');
            $unitPrice = (float) ($request->input('unit_price') ?: $product->base_price);
            $editItemId = $request->input('edit_cart_item_id');

            // Edit mode: update existing cart item
            if ($editItemId) {
                $existingItem = CartItem::where('cart_id', $cart->id)->find($editItemId);
                if ($existingItem) {
                    $existingItem->update([
                        'product_id'       => $product->id,
                        'product_name'     => $customData['product_label'] ?? $product->name,
                        'image_url'        => $img,
                        'quantity'         => $quantity,
                        'unit_price'       => $unitPrice,
                        'options_snapshot' => $options,
                        'custom_data'      => $customData,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'อัปเดตรายการสินค้า Custom ในตะกร้าเรียบร้อยแล้ว',
                    ]);
                }
            }

            // New item
            CartItem::create([
                'cart_id'          => $cart->id,
                'product_id'      => $product->id,
                'product_name'    => $customData['product_label'] ?? $product->name,
                'image_url'       => $img,
                'quantity'        => $quantity,
                'unit_price'      => $unitPrice,
                'options_snapshot' => $options,
                'custom_data'     => $customData,
                'is_preorder'     => true,
                'lead_time'       => '14-21 วันทำการ',
                'is_selected'     => true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'เพิ่มรายการสินค้าสั่งทำ (Custom) ลงตะกร้าเรียบร้อยแล้ว',
            ]);
        }

        // 2. Ready-to-Ship Product Flow — ใช้ราคาตามจำนวน (Price Tiers)
        $stock = $product->stock_qty;
        $isPreorder = $stock <= 0;
        
        // Request Preorder Confirmation if out of stock
        if ($isPreorder && !$request->input('confirm_preorder')) {
            return response()->json([
                'requires_preorder_confirm' => true,
                'message' => 'ตอนนี้สินค้าไม่มีในสต็อก ระบบจะบันทึกเป็นรายการพรีออเดอร์ (รอผลิต 14-21 วัน) คุณต้องการยืนยันหรือไม่?',
            ]);
        }

        $existingReadyItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('is_preorder', false)
            ->get()
            ->firstWhere('options_snapshot', $options);
            
        $existingPreorderItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('is_preorder', true)
            ->get()
            ->firstWhere('options_snapshot', $options);

        if (!$isPreorder && $quantity > $stock) {
            // Stock split needed
            $readyQty = $stock;
            if ($existingReadyItem) {
                $newReadyQty = $existingReadyItem->quantity + $readyQty;
                $existingReadyItem->update([
                    'quantity'   => $newReadyQty,
                    'unit_price' => $product->getPriceForQty($newReadyQty),
                ]);
            } else {
                CartItem::create([
                    'cart_id'      => $cart->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'image_url'    => $img,
                    'quantity'     => $readyQty,
                    'unit_price'   => $product->getPriceForQty($readyQty),
                    'options_snapshot' => $options,
                    'is_preorder'  => false,
                    'lead_time'    => '1-3 วันทำการ',
                    'is_selected'  => true,
                ]);
            }

            $preorderQty = $quantity - $stock;
            if ($existingPreorderItem) {
                $newPreorderQty = $existingPreorderItem->quantity + $preorderQty;
                $existingPreorderItem->update([
                    'quantity'   => $newPreorderQty,
                    'unit_price' => $product->getPriceForQty($newPreorderQty),
                ]);
            } else {
                CartItem::create([
                    'cart_id'      => $cart->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'image_url'    => $img,
                    'quantity'     => $preorderQty,
                    'unit_price'   => $product->getPriceForQty($preorderQty),
                    'options_snapshot' => $options,
                    'is_preorder'  => true,
                    'lead_time'    => '14-21 วันทำการ',
                    'is_selected'  => true,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "สินค้าพร้อมส่งมีจำนวน {$stock} ชิ้น ส่วนที่เกิน ({$preorderQty} ชิ้น) ถูกจัดเป็นรายการพรีออเดอร์เรียบร้อยแล้ว",
            ]);
        }

        // No split needed
        if ($isPreorder) {
            if ($existingPreorderItem) {
                $newPreorderQty = $existingPreorderItem->quantity + $quantity;
                $existingPreorderItem->update([
                    'quantity'   => $newPreorderQty,
                    'unit_price' => $product->getPriceForQty($newPreorderQty),
                ]);
            } else {
                CartItem::create([
                    'cart_id'      => $cart->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'image_url'    => $img,
                    'quantity'     => $quantity,
                    'unit_price'   => $product->getPriceForQty($quantity),
                    'options_snapshot' => $options,
                    'is_preorder'  => true,
                    'lead_time'    => '14-21 วันทำการ',
                    'is_selected'  => true,
                ]);
            }
        } else {
            if ($existingReadyItem) {
                $newReadyQty = $existingReadyItem->quantity + $quantity;
                $existingReadyItem->update([
                    'quantity'   => $newReadyQty,
                    'unit_price' => $product->getPriceForQty($newReadyQty),
                ]);
            } else {
                CartItem::create([
                    'cart_id'      => $cart->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'image_url'    => $img,
                    'quantity'     => $quantity,
                    'unit_price'   => $product->getPriceForQty($quantity),
                    'options_snapshot' => $options,
                    'is_preorder'  => false,
                    'lead_time'    => '1-3 วันทำการ',
                    'is_selected'  => true,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มสินค้าลงตะกร้าเรียบร้อยแล้ว',
        ]);
    }

    /**
     * Update item quantity with stock validation & auto-split prompt support.
     */
    public function updateQuantity(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $newQty = max(1, (int) $request->input('quantity', 1));
        $product = $item->product;

        // Stock check only if currently a ready-to-ship item
        if (!$item->is_preorder && $product) {
            // Restore the item's own quantity to available stock for math
            $stock = $product->stock_qty + $item->quantity;
            if ($newQty > $stock) {
                // Return alert requirement payload for SweetAlert popup
                return response()->json([
                    'requires_split'  => true,
                    'item_id'         => $item->id,
                    'available_stock' => $stock,
                    'requested_qty'   => $newQty,
                    'excess_qty'      => $newQty - $stock,
                    'message'         => "สินค้าพร้อมส่งมีจำนวน {$stock} ชิ้น ส่วนที่เกิน (" . ($newQty - $stock) . " ชิ้น) จะถูกเปลี่ยนเป็นรายการพรีออเดอร์ คุณยืนยันหรือไม่?",
                ]);
            }
        }

        $item->update(['quantity' => $newQty]);

        return $this->getCartSummaryResponse($item->cart);
    }

    /**
     * Perform confirmed split for item exceeding stock.
     */
    public function confirmSplit(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $product = $item->product;
        $requestedQty = max(1, (int) $request->input('requested_qty'));

        $stock = $product ? ($product->stock_qty + $item->quantity) : 0;
        $excessQty = max(1, $requestedQty - $stock);

        // 1. Cap current ready-to-ship item at available stock
        $item->update([
            'quantity'    => $stock,
            'is_preorder' => false,
            'lead_time'   => '1-3 วันทำการ',
        ]);

        // 2. Create or update pre-order row for excess quantity
        $existingPreorderItem = CartItem::where('cart_id', $item->cart_id)
            ->where('product_id', $item->product_id)
            ->where('is_preorder', true)
            ->where('id', '!=', $item->id)
            ->get()
            ->firstWhere('options_snapshot', $item->options_snapshot);

        if ($existingPreorderItem) {
            $newPreorderQty = $existingPreorderItem->quantity + $excessQty;
            $existingPreorderItem->update([
                'quantity'   => $newPreorderQty,
                'unit_price' => $product ? $product->getPriceForQty($newPreorderQty) : $item->unit_price,
            ]);
        } else {
            CartItem::create([
                'cart_id'          => $item->cart_id,
                'product_id'       => $item->product_id,
                'product_name'     => $item->product_name,
                'image_url'        => $item->image_url,
                'quantity'         => $excessQty,
                'unit_price'       => $product ? $product->getPriceForQty($excessQty) : $item->unit_price,
                'options_snapshot' => $item->options_snapshot,
                'is_preorder'      => true,
                'lead_time'        => '14-21 วันทำการ',
                'is_selected'      => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'reload'  => true,
            'message' => 'แยกรายการสินค้าพร้อมส่งและพรีออเดอร์เรียบร้อยแล้ว',
        ]);
    }

    /**
     * Toggle selection state for item or group.
     */
    public function toggleSelect(Request $request, $id = null)
    {
        $cart = $this->getOrCreateCart($request);

        if ($id === 'all') {
            $selectState = $request->boolean('selected');
            $cart->items()->update(['is_selected' => $selectState]);
        } elseif ($id === 'ready') {
            $selectState = $request->boolean('selected');
            $cart->readyToShipItems()->update(['is_selected' => $selectState]);
        } elseif ($id === 'preorder') {
            $selectState = $request->boolean('selected');
            $cart->preorderItems()->update(['is_selected' => $selectState]);
        } else {
            $item = CartItem::findOrFail($id);
            $item->update(['is_selected' => !$item->is_selected]);
        }

        return $this->getCartSummaryResponse($cart);
    }

    /**
     * Remove item from cart.
     */
    public function destroy($id)
    {
        $item = CartItem::findOrFail($id);
        $cart = $item->cart;
        $item->delete();

        return response()->json([
            'success' => true,
            'reload'  => true,
            'message' => 'ลบรายการสินค้าออกจากตะกร้าเรียบร้อยแล้ว',
        ]);
    }

    /**
     * Get real-time cart item count.
     */
    public function count(Request $request)
    {
        $cart = $this->getOrCreateCart($request);
        return response()->json(['count' => $cart->items()->sum('quantity')]);
    }

    /**
     * Helper to return summary metadata response for AJAX requests.
     */
    private function getCartSummaryResponse(Cart $cart)
    {
        $cart->refresh();

        return response()->json([
            'success'             => true,
            'ready_count'         => $cart->selected_ready_count,
            'preorder_count'      => $cart->selected_preorder_count,
            'total_count'         => $cart->selected_total_count,
            'subtotal'            => number_format($cart->selected_subtotal, 2),
            'shipping_fee'        => number_format($cart->shipping_fee, 2),
            'grand_total'         => number_format($cart->grand_total, 2),
        ]);
    }
}
