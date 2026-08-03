{{-- ══════════════════════════════════════════════
     SCREEN BANNER SLIDER
     Shown only when สกรีนลาย / สายคล้องสั่งทำ filter is active
══════════════════════════════════════════════ --}}
<div class="screen-slider-wrapper" id="screenSlider" style="display:none;">
    <div class="screen-slider-track" id="screenSliderTrack">
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-1.jpg') }}" alt="Banner 1"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-2.jpg') }}" alt="Banner 2"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-3.jpg') }}" alt="Banner 3"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-4.jpg') }}" alt="Banner 4"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-5.jpg') }}" alt="Banner 5"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-6.jpg') }}" alt="Banner 6"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-7.jpg') }}" alt="Banner 7"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-8.jpg') }}" alt="Banner 8"></div>
    </div>
    <button class="screen-slider-btn screen-slider-prev" id="sliderPrev" onclick="slideScreen(-1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="screen-slider-btn screen-slider-next" id="sliderNext" onclick="slideScreen(1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
    <div class="screen-slider-dots" id="screenSliderDots"></div>
</div>

{{-- ══════════════════════════════════════════════
     OTHER LANYARDS SLIDER
     Shown only when สายคล้องอื่น ๆ filter is active
══════════════════════════════════════════════ --}}
<div class="screen-slider-wrapper" id="otherSlider" style="display:none;">
    <div class="screen-slider-track" id="otherSliderTrack">
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-6.jpg') }}" alt="Banner 6"></div>
        <div class="screen-slide"><img src="{{ asset('images/banners/screen/slide-7.jpg') }}" alt="Banner 7"></div>
    </div>
    <button class="screen-slider-btn screen-slider-prev" onclick="slideOther(-1)">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
    <button class="screen-slider-btn screen-slider-next" onclick="slideOther(1)">
        <i class="fa-solid fa-chevron-right"></i>
    </button>
    <div class="screen-slider-dots" id="otherSliderDots"></div>
</div>

{{-- ══════════════════════════════════════════════
     BADGE HOLDER SCREEN SERVICE BANNER
     Shown only when กรอบ/ซองใส่บัตร filter is active
══════════════════════════════════════════════ --}}
<div class="screen-slider-wrapper" id="badgeHolderBanner" style="display:none;">
    <a href="{{ route('products.index', ['category_slugs' => ['badge-holders']]) }}" class="block w-full overflow-hidden rounded-[4px] group" title="บริการสกรีนซองใส่บัตร">
        <img src="{{ asset('images/banners/screen/badge-holder-screen-banner.png') }}" alt="บริการสกรีนซองใส่บัตร" class="w-full h-auto object-cover group-hover:scale-[1.01] transition-transform duration-300" />
    </a>
</div>

{{-- ══════════════════════════════════════════════
     OCCASION BANNERS
══════════════════════════════════════════════ --}}
<div class="screen-slider-wrapper" id="officeBanner" style="display:none;">
    <div class="w-full overflow-hidden rounded-[4px]">
        <img src="{{ asset('images/banners/screen/office-banner.png') }}" alt="สำนักงานบริษัท" class="w-full h-auto object-cover" />
    </div>
</div>

<div class="screen-slider-wrapper" id="schoolBanner" style="display:none;">
    <div class="w-full overflow-hidden rounded-[4px]">
        <img src="{{ asset('images/banners/screen/school-banner.png') }}" alt="โรงเรียน" class="w-full h-auto object-cover" />
    </div>
</div>

<div class="screen-slider-wrapper" id="eventBanner" style="display:none;">
    <div class="w-full overflow-hidden rounded-[4px]">
        <img src="{{ asset('images/banners/screen/event-banner.png') }}" alt="งานอีเว้นท์" class="w-full h-auto object-cover" />
    </div>
</div>
