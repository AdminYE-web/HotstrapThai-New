@if($product->category && $product->category->slug === 'lanyard-parts')
<div x-data="{ quickViewOpen: false, quickViewIndex: 0 }"
     class="product-card cursor-pointer"
     @click="quickViewOpen = true"
     aria-label="{{ $product->name }}">
    <div class="product-img-wrap">
        @if($product->primaryImage)
            <img src="{{ asset($product->primaryImage->image_path) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 onerror="this.src='{{ asset('images/no-image.svg') }}'">
        @else
            <img src="{{ asset('images/no-image.svg') }}"
                 alt="{{ $product->name }}"
                 loading="lazy">
        @endif
        @if($product->type === 'ready_to_ship')
            @if($product->stock_qty > 0)
                <span class="badge-ready">พร้อมส่ง</span>
            @else
                <span class="badge-preorder">พรีออร์เดอร์</span>
            @endif
        @endif
    </div>
    <div class="product-info">
        <div class="product-name">{{ $product->name }}</div>
    </div>
    
    <!-- Quick View Modal (Teleported to Body) -->
    <template x-teleport="body">
        <div x-show="quickViewOpen" 
             style="display: none; z-index: 9999;" 
             class="fixed inset-0 bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm"
             @keydown.window.escape="quickViewOpen = false">
             
            <!-- Modal Container -->
            <div @click.away="quickViewOpen = false" 
                 class="bg-white rounded-xl shadow-2xl w-full max-h-[90vh] overflow-y-auto flex flex-col relative"
                 style="max-width: 500px;">
                 
                <!-- Close Button -->
                <button @click="quickViewOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-800 transition-colors z-20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                @php
                    $allImages = [];
                    if ($product->images->count() > 0) {
                        foreach($product->images->sortBy('order') as $img) {
                            $allImages[] = asset($img->image_path);
                        }
                    } else if ($product->primaryImage) {
                        $allImages[] = asset($product->primaryImage->image_path);
                    } else {
                        $allImages[] = asset('images/no-image.svg');
                    }
                @endphp
                <div x-data="{ images: {{ json_encode($allImages) }} }" class="w-full bg-white relative flex flex-col items-center justify-center pt-8 pb-4 min-h-[250px] border-b border-gray-50">
                    <div class="relative w-full flex items-center justify-center px-12">
                        <!-- Carousel Prev -->
                        <button x-show="images.length > 1" @click.stop="quickViewIndex = (quickViewIndex - 1 + images.length) % images.length" class="absolute left-2 bg-white hover:bg-gray-50 rounded-full p-1.5 text-gray-400 transition-all z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        
                        <!-- Image -->
                        <img :src="images[quickViewIndex]" 
                             alt="{{ $product->name }}" 
                             class="max-w-full h-auto max-h-[40vh] object-contain rounded-lg">
                        
                        <!-- Carousel Next -->
                        <button x-show="images.length > 1" @click.stop="quickViewIndex = (quickViewIndex + 1) % images.length" class="absolute right-2 bg-white hover:bg-gray-50 rounded-full p-1.5 text-gray-400 transition-all z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                    
                    <!-- Dots -->
                    <div x-show="images.length > 1" class="mt-6 flex justify-center gap-2">
                        <template x-for="(img, idx) in images" :key="idx">
                            <span @click.stop="quickViewIndex = idx" 
                                  class="w-2 h-2 rounded-full cursor-pointer transition-colors border border-gray-300" 
                                  :class="quickViewIndex === idx ? 'bg-black border-black' : 'bg-white hover:bg-gray-100'"></span>
                        </template>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="w-full p-6 md:px-8 md:py-6 flex flex-col">
                    <div class="flex items-center flex-wrap gap-x-3 gap-y-2 mb-4 pr-6">
                        <h3 class="text-[17px] font-bold text-black">{{ $product->name }}</h3>
                        
                        <a href="https://youtu.be/26iEaMBYQ7Y?si=zWa8dsQ-bz8y4I1P" target="_blank" class="inline-flex items-center gap-1.5 bg-[#E53935] hover:bg-red-700 text-white px-3 py-1 rounded-full text-[12px] font-medium transition-colors shadow-sm">
                            วีดีโอสาธิตการใช้งาน
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </a>
                    </div>
                    
                    <div class="space-y-1.5 text-[13.5px] text-gray-800 mb-6 flex-grow">
                        @if($product->productMaterial || ($product->variants && $product->variants->first() && $product->variants->first()->material))
                            <p><strong class="text-black font-bold">วัสดุ:</strong> {{ $product->productMaterial ?? $product->variants->first()->material ?? '' }}</p>
                        @endif
                        @if($product->productColor || ($product->variants && $product->variants->first() && $product->variants->first()->color))
                            <p><strong class="text-black font-bold">สี:</strong> {{ $product->productColor ?? $product->variants->first()->color ?? '' }}</p>
                        @endif
                        @if($product->productSize || ($product->variants && $product->variants->first() && $product->variants->first()->size))
                            <p><strong class="text-black font-bold">ขนาดเส้นที่คล้องพาร์ทได้:</strong> {{ $product->productSize ?? $product->variants->first()->size ?? '' }}</p>
                        @endif
                        
                        @if($product->description)
                            <div class="mt-3 pt-3">
                                <strong class="text-black font-bold block mb-1">รายละเอียด:</strong>
                                <div class="text-gray-700 leading-relaxed">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-2">
                        <p class="text-[#E53935] text-[13px] font-bold mb-3 text-center">*** หากสนใจ กรุณาติดต่อเรา ***</p>
                        <a href="#" class="w-full bg-black hover:bg-gray-900 text-white text-[14px] font-bold py-3 rounded-sm transition-colors flex justify-center items-center shadow-sm">
                            ติดต่อฝ่ายขาย
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@else
<a href="{{ route('products.show', $product->slug) }}"
   class="product-card"
   aria-label="{{ $product->name }}">
    <div class="product-img-wrap">
        @if($product->primaryImage)
            <img src="{{ asset($product->primaryImage->image_path) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 onerror="this.src='{{ asset('images/no-image.svg') }}'">
        @else
            <img src="{{ asset('images/no-image.svg') }}"
                 alt="{{ $product->name }}"
                 loading="lazy">
        @endif
        @if($product->type === 'ready_to_ship')
            @if($product->stock_qty > 0)
                <span class="badge-ready">พร้อมส่ง</span>
            @else
                <span class="badge-preorder">พรีออร์เดอร์</span>
            @endif
        @endif
    </div>
    <div class="product-info">
        <div class="product-name">{{ $product->name }}</div>
    </div>
</a>
@endif
