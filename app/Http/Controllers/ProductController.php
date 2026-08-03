<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomPricingRate;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of all products with filters & infinite scroll AJAX support.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $query = Product::query()
            ->with(['category', 'primaryImage', 'detail'])
            ->where('is_active', true);

        // 1. Filter by Category Slugs (Array)
        if ($request->has('category_slugs') && is_array($request->category_slugs) && count($request->category_slugs) > 0) {
            $slugs = $request->category_slugs;

            // If 'accessories' main group is selected, include its subcategories
            if (in_array('accessories', $slugs)) {
                $slugs = array_merge($slugs, ['badge-holders', 'yoyo-badge-holders', 'lanyard-parts', 'carabiners']);
            }

            $query->whereHas('category', function ($q) use ($slugs) {
                $q->whereIn('slug', $slugs);
            });
        }
        // Fallback for ID-based categories
        elseif ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $query->whereIn('category_id', $request->categories);
        }

        // 2. Filter by Print Types (screened, plain)
        if ($request->has('print_types') && is_array($request->print_types) && count($request->print_types) > 0) {
            $printTypes = $request->print_types;
            $query->where(function ($q) use ($printTypes) {
                if (in_array('screened', $printTypes)) {
                    $q->orWhere(function ($sub) {
                        $sub->where('name', 'like', '%สกรีน%')
                            ->where('name', 'not like', '%ไม่สกรีน%');
                    });
                }
                if (in_array('plain', $printTypes)) {
                    $q->orWhere('name', 'like', '%ไม่สกรีน%');
                }
            });
        }

        if ($request->filled('is_ready_to_ship') && $request->is_ready_to_ship == '1') {
            $query->whereHas('detail.productType', function ($q) {
                $q->where('slug', 'ready_to_ship');
            });
        }

        if ($request->has('types') && is_array($request->types) && count($request->types) > 0) {
            $types = $request->types;
            $query->whereHas('detail.productType', function ($q) use ($types) {
                $q->whereIn('slug', $types);
            });
        }

        if ($request->has('occasions') && is_array($request->occasions) && count($request->occasions) > 0) {
            $occasions = $request->occasions;
            $query->whereHas('detail.occasionType', function ($q) use ($occasions) {
                $q->whereIn('slug', $occasions);
            });
        }

        // Search by Product Name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . trim($request->search) . '%');
        }

        // Sort Order (default: id asc = show from product #1)
        $sort = $request->get('sort', 'oldest');
        if ($sort === 'price_low') {
            $query->orderBy('base_price', 'asc');
        } elseif ($sort === 'price_high') {
            $query->orderBy('base_price', 'desc');
        } elseif ($sort === 'latest') {
            $query->orderBy('id', 'desc');
        } else {
            // default 'oldest': show from ID 1
            $query->orderBy('id', 'asc');
        }

        // Paginate 15 items per page (5 rows x 3 cards on PC)
        $products = $query->paginate(15)->withQueryString();

        // If AJAX request, return rendered product grid partial & pagination metadata
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'html' => view('products.partials.product-grid', compact('products'))->render(),
                'hasMorePages' => $products->hasMorePages(),
                'nextPageUrl' => $products->nextPageUrl(),
                'total' => $products->total(),
            ]);
        }

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product detail page.
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'detail', 'variants', 'prices'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::with(['category', 'primaryImage', 'detail'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Display the customizer engine for a specific custom product.
     */
    public function customize(Request $request, $slug)
    {
        $product = Product::with(['category', 'images', 'detail', 'variants', 'prices'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // All custom lanyard products for Step 1 dropdown (only main 9 types)
        $allCustomProducts = Product::with(['primaryImage', 'images', 'prices', 'customConfig'])
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])
            ->where('is_active', true)
            ->orderBy('id')
            ->get();

        // Build TYPE_CONFIG map from database for frontend
        $typeConfigs = [];
        foreach ($allCustomProducts as $p) {
            if ($p->customConfig) {
                $cfg = $p->customConfig;
                $typeConfigs[$p->id] = [
                    'group'          => $cfg->config_group,
                    'sizes'          => $cfg->available_sizes ?? [],
                    'showScreen'     => $cfg->show_screen,
                    'showClip'       => $cfg->show_clip,
                    'showStep2'      => $cfg->show_step2,
                    'showStep3'      => $cfg->show_step3,
                    'step2Mode'      => $cfg->step2_mode,
                    'step3Mode'      => $cfg->step3_mode,
                    'showFreeParts'  => $cfg->show_free_parts,
                    'allowedSpecial' => $cfg->allowed_special_parts ?? [],
                ];
            }
        }

        // Get Lanyard Parts (Accessories)
        $parts = Product::with(['primaryImage', 'variants'])
            ->whereHas('category', function($q) {
                $q->where('slug', 'lanyard-parts');
            })
            ->where('is_active', true)
            ->get();

        // Get YoYo Parts (for สายคล้อง+โยโย่ special case in Step 4)
        $yoyoParts = Product::with(['primaryImage', 'variants'])
            ->whereHas('category', function($q) {
                $q->where('slug', 'yoyo-badge-holders');
            })
            ->where('is_active', true)
            ->get();

        // Get Card Holders
        $cardHolders = Product::with(['primaryImage', 'variants', 'prices'])
            ->whereHas('category', function($q) {
                $q->where('slug', 'badge-holders');
            })
            ->where('is_active', true)
            ->get();

        // Get custom pricing rates for frontend calculation
        $customRates = CustomPricingRate::getAllRatesForFrontend();

        $editSelections = null;
        $editCartItemId = null;
        $editProductId = null;

        if ($request->has('cart_item')) {
            $cartItem = \App\Models\CartItem::find($request->input('cart_item'));
            if ($cartItem && $cartItem->custom_data && isset($cartItem->custom_data['selections'])) {
                $editSelections = $cartItem->custom_data['selections'];
                $editCartItemId = $cartItem->id;
                $editProductId = $cartItem->product_id;
            }
        }

        return view('products.customize', compact('product', 'allCustomProducts', 'parts', 'yoyoParts', 'cardHolders', 'customRates', 'typeConfigs', 'editSelections', 'editCartItemId', 'editProductId'));
    }
}
