/* ══════════════════════════════════════════════════════════
   Products Index Page — JavaScript
   ══════════════════════════════════════════════════════════
   NOTE: CONFIG variables (BASE_URL, nextPage, hasMore) are
   declared inline in index.blade.php because they use Blade
   template data. This file assumes they are already defined.
   ══════════════════════════════════════════════════════════ */

/* ─── FILTER STATE ─── */
const state = {
    types:        [],
    categories:   [],
    availability: false,
    usages:       [],
};

/* ─── ACCESSORY GROUP TOGGLE ─── */
const ACCESSORY_SLUGS = ['badge-holders', 'yoyo-badge-holders', 'lanyard-parts', 'carabiners'];

function toggleAccGroup(forceOpen) {
    const btn  = document.getElementById('accGroupToggle');
    const body = document.getElementById('accGroupBody');
    if (!btn || !body) return;
    const isOpen = btn.classList.contains('open');
    const shouldOpen = forceOpen !== undefined ? forceOpen : !isOpen;
    if (shouldOpen) {
        body.style.display = 'block';
        btn.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
    } else {
        body.style.display = 'none';
        btn.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
    }
}

/* ─── HELPER: clear ALL filter state ─── */
function clearAllState() {
    state.types        = [];
    state.categories   = [];
    state.availability = false;
    state.usages       = [];
}

/* ─── FILTER EVENTS (global single-select: only 1 item active at a time) ─── */
function onFilter(key, value, checked) {
    if (checked) {
        clearAllState();
        if (key === 'availability') {
            state.availability = true;
        } else {
            state[key] = [value];
        }
    } else {
        if (key === 'availability') {
            state.availability = false;
        } else {
            state[key] = [];
        }
    }
    syncAllUI();
    scheduleFetch();
    closeMobileFilter(); // auto-close drawer on mobile after selection
}

function onFilterAll(checked) {
    if (checked) {
        clearAllState(); // clear everything → shows all products
        syncAllUI();
        scheduleFetch();
        closeMobileFilter();
    } else {
        // Can't uncheck "all" — re-check it
        syncAllUI();
    }
}

function toggleAvail() {
    const newVal = !state.availability;
    clearAllState();
    state.availability = newVal;
    syncAllUI();
    scheduleFetch();
}

function resetFilters() {
    state.types = []; state.categories = []; state.availability = false; state.usages = [];
    document.getElementById('sortSelect').value = 'oldest';
    syncAllUI();
    scheduleFetch();
    closeAllDropdowns();
}

/* ─── SYNC CHECKBOXES (sidebar ↔ top bar ↔ mobile drawer) ─── */
function syncAllUI() {
    const isAll = state.types.length === 0 && state.categories.length === 0 && !state.availability && state.usages.length === 0;
    /* Sidebar: types (including "all") */
    setCheck('sb-type-all',     isAll);
    setCheck('sb-type-screen',  state.types.includes('screen'));
    setCheck('sb-type-noscreen',state.types.includes('noscreen'));
    /* Sidebar: "all" label styling */
    const sbLblAll = document.getElementById('sb-lbl-all');
    if (sbLblAll) sbLblAll.classList.toggle('checked', isAll);
    /* Sidebar: categories (dynamic IDs) */
    document.querySelectorAll('.sb-cat-cb').forEach(cb => {
        const on = state.categories.includes(cb.value);
        cb.checked = on;
        const lbl = cb.closest('.checkbox-item');
        if (lbl) lbl.classList.toggle('checked', on);
    });
    /* Auto-expand accessories group if any accessory is selected */
    const hasActiveAcc = ACCESSORY_SLUGS.some(s => state.categories.includes(s));
    if (hasActiveAcc) toggleAccGroup(true);
    /* Sidebar: availability */
    setCheck('sb-avail', state.availability);
    /* Sidebar: usages */
    setCheck('sb-usage-office', state.usages.includes('office'));
    setCheck('sb-usage-school', state.usages.includes('school'));
    setCheck('sb-usage-event',  state.usages.includes('event'));
    /* Top bar: types (including "all") */
    setCheck('top-type-all',      isAll);
    setCheck('top-type-screen',   state.types.includes('screen'));
    setCheck('top-type-noscreen', state.types.includes('noscreen'));
    /* Top bar: categories */
    document.querySelectorAll('.top-cat-cb').forEach(cb => {
        cb.checked = state.categories.includes(cb.value);
    });
    /* Top bar: usages */
    setCheck('top-usage-office', state.usages.includes('office'));
    setCheck('top-usage-school', state.usages.includes('school'));
    setCheck('top-usage-event',  state.usages.includes('event'));

    /* ── Mobile drawer: types (including "all") ── */
    setCheck('mob-type-all',      isAll);
    setCheck('mob-type-screen',   state.types.includes('screen'));
    setCheck('mob-type-noscreen', state.types.includes('noscreen'));
    /* Mobile drawer: "all" label styling */
    const mobLblAll = document.getElementById('mob-lbl-all');
    if (mobLblAll) mobLblAll.classList.toggle('checked', isAll);
    /* Mobile drawer: categories */
    document.querySelectorAll('.mob-cat-cb').forEach(cb => {
        const on = state.categories.includes(cb.value);
        cb.checked = on;
        const lbl = cb.closest('.mobile-filter-option');
        if (lbl) lbl.classList.toggle('checked', on);
    });
    /* Mobile drawer: auto-expand acc if active */
    const hasMobActiveAcc = ACCESSORY_SLUGS.some(s => state.categories.includes(s));
    if (hasMobActiveAcc) {
        const body = document.getElementById('mobileAccBody');
        const trigger = document.getElementById('mobAccTrigger');
        if (body) body.style.display = 'block';
        if (trigger) trigger.classList.add('open');
    }
    /* Mobile drawer: availability */
    setCheck('mob-avail', state.availability);
    /* Mobile drawer: usages */
    setCheck('mob-usage-office', state.usages.includes('office'));
    setCheck('mob-usage-school', state.usages.includes('school'));
    setCheck('mob-usage-event',  state.usages.includes('event'));
    /* Mobile drawer: update styled labels */
    ['mob-type-screen','mob-type-noscreen','mob-avail','mob-usage-office','mob-usage-school','mob-usage-event'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        const lbl = el.closest('.mobile-filter-option');
        if (lbl) lbl.classList.toggle('checked', el.checked);
    });

    /* Update styled labels (sidebar) */
    ['sb-type-screen','sb-type-noscreen','sb-avail','sb-usage-office','sb-usage-school','sb-usage-event'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        const lbl = el.closest('.checkbox-item');
        if (lbl) lbl.classList.toggle('checked', el.checked);
    });
    updateBadges();
    updateScreenSlider();
}

function setCheck(id, val) {
    const el = document.getElementById(id);
    if (el) el.checked = val;
}

function updateBadges() {
    const tc = state.types.length, cc = state.categories.length, uc = state.usages.length;
    setBadge('badge-type',  tc, 'pill-type',  tc > 0);
    setBadge('badge-cat',   cc, 'pill-cat',   cc > 0);
    setBadge('badge-usage', uc, 'pill-usage', uc > 0);
    const avBadge = document.getElementById('badge-avail');
    const avPill  = document.getElementById('pill-avail');
    avBadge.style.display = state.availability ? 'inline-flex' : 'none';
    avPill.classList.toggle('has-active', state.availability);
}

function setBadge(badgeId, count, pillId, isActive) {
    const b = document.getElementById(badgeId);
    const p = document.getElementById(pillId);
    b.style.display = isActive ? 'inline-flex' : 'none';
    b.textContent = count;
    p.classList.toggle('has-active', isActive);
}

/* ─── FETCH PRODUCTS FROM SERVER ─── */
function buildParams(page) {
    const params = new URLSearchParams();
    state.types.forEach(t => {
        if (t === 'screen')   params.append('print_types[]', 'screened');
        if (t === 'noscreen') params.append('print_types[]', 'plain');
    });
    state.categories.forEach(c => params.append('category_slugs[]', c));
    if (state.availability) params.set('is_ready_to_ship', '1');
    state.usages.forEach(u => params.append('occasions[]', u));
    params.set('sort', document.getElementById('sortSelect').value);
    if (page) params.set('page', page);
    return params;
}

/* ─── DEBOUNCE FETCH ─── */
function scheduleFetch() {
    clearTimeout(fetchTimer);
    fetchTimer = setTimeout(() => doFetch(), 150);
}

async function doFetch(append = false) {
    if (isFetching) {
        clearTimeout(fetchTimer);
        fetchTimer = setTimeout(() => doFetch(), 200);
        return;
    }
    isFetching = true;
    const indicator = document.getElementById('loading-indicator');
    indicator.style.display = 'block';

    try {
        const url = BASE_URL + '?' + buildParams();
        const resp = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        if (!resp.ok) throw new Error('HTTP ' + resp.status);
        const data = await resp.json();

        const grid = document.getElementById('productGrid');
        if (append) {
            grid.insertAdjacentHTML('beforeend', data.html);
        } else {
            grid.innerHTML = data.html;
            grid.querySelectorAll('.product-card').forEach((c, i) => {
                c.style.animationDelay = (i * 40) + 'ms';
            });
        }

        document.getElementById('countNum').textContent = data.total;
        hasMore  = data.hasMorePages;
        nextPage = data.nextPageUrl;
    } catch(e) {
        console.error('Filter fetch error:', e);
    } finally {
        isFetching = false;
        indicator.style.display = 'none';
    }
}

/* ─── INFINITE SCROLL ─── */
const sentinel = document.getElementById('scroll-sentinel');
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && hasMore && !isFetching) {
        fetchMore();
    }
}, { rootMargin: '200px' });
observer.observe(sentinel);

async function fetchMore() {
    if (!nextPage || !hasMore || isFetching) return;
    isFetching = true;
    document.getElementById('loading-indicator').style.display = 'block';
    try {
        const url = nextPage + '&' + buildParams();
        const resp = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await resp.json();
        const grid = document.getElementById('productGrid');
        const temp = document.createElement('div');
        temp.innerHTML = data.html;
        let delay = grid.querySelectorAll('.product-card').length * 40;
        temp.querySelectorAll('.product-card').forEach((c, i) => {
            c.style.animationDelay = (delay + i * 40) + 'ms';
            grid.appendChild(c);
        });
        hasMore  = data.hasMorePages;
        nextPage = data.nextPageUrl;
        document.getElementById('countNum').textContent = data.total;
    } catch(e) {
        console.error('Infinite scroll error:', e);
    } finally {
        isFetching = false;
        document.getElementById('loading-indicator').style.display = 'none';
    }
}

/* ─── DROPDOWN TOGGLE ─── */
document.querySelectorAll('.top-filter-pill[data-target]').forEach(btn => {
    btn.addEventListener('click', () => {
        const panelId = btn.getAttribute('data-target');
        const panel   = document.getElementById(panelId);
        const isOpen  = panel.classList.contains('open');
        closeAllDropdowns();
        if (!isOpen) {
            panel.classList.add('open');
            btn.classList.add('open');
        }
    });
});

function closeAllDropdowns() {
    document.querySelectorAll('.dropdown-panel.open').forEach(p => p.classList.remove('open'));
    document.querySelectorAll('.top-filter-pill.open').forEach(b => b.classList.remove('open'));
    closeTopAccPanel();
}

function closeTopAccPanel() {
    const panel   = document.getElementById('topAccPanel');
    const trigger = document.getElementById('topAccTrigger');
    if (panel)   panel.classList.remove('open');
    if (trigger) trigger.classList.remove('open');
}

function toggleTopAccPanel(e) {
    e.stopPropagation();
    const panel   = document.getElementById('topAccPanel');
    const trigger = document.getElementById('topAccTrigger');
    const isOpen  = panel.classList.contains('open');
    if (isOpen) {
        closeTopAccPanel();
    } else {
        panel.classList.add('open');
        trigger.classList.add('open');
    }
}

document.addEventListener('click', e => {
    if (!e.target.closest('.top-filter-group')) closeAllDropdowns();
});

/* ─── SCROLL DETECTION: sidebar bottom → viewport top ─── */
const topBar = document.getElementById('topFilterBar');
const sidebar = document.getElementById('sidebarFilter');
const siteHeader = document.querySelector('header');

function updateTopBarOffset() {
    if (siteHeader && topBar) {
        const headerH = siteHeader.offsetHeight;
        topBar.style.top = headerH + 'px';
    }
}
updateTopBarOffset();
window.addEventListener('resize', updateTopBarOffset, { passive: true });

window.addEventListener('scroll', () => {
    if (!sidebar) return;
    const rect = sidebar.getBoundingClientRect();
    if (rect.bottom <= 0) {
        topBar.classList.add('visible');
    } else {
        topBar.classList.remove('visible');
        closeAllDropdowns();
    }
}, { passive: true });

/* ══════════════════════════════════════════════════════════
   SCREEN BANNER SLIDER
   ══════════════════════════════════════════════════════════ */
let screenSlideIndex = 0;
let screenSlideTimer = null;
const SCREEN_SLIDE_COUNT = 8;
const SCREEN_SLIDE_INTERVAL = 2000; // 2 seconds per slide

function initScreenSlider() {
    const dotsContainer = document.getElementById('screenSliderDots');
    if (!dotsContainer) return;
    dotsContainer.innerHTML = '';
    for (let i = 0; i < SCREEN_SLIDE_COUNT; i++) {
        const dot = document.createElement('span');
        dot.className = 'screen-slider-dot' + (i === 0 ? ' active' : '');
        dot.onclick = () => goToScreenSlide(i);
        dotsContainer.appendChild(dot);
    }
}

function goToScreenSlide(index) {
    screenSlideIndex = ((index % SCREEN_SLIDE_COUNT) + SCREEN_SLIDE_COUNT) % SCREEN_SLIDE_COUNT;
    const track = document.getElementById('screenSliderTrack');
    if (track) track.style.transform = `translateX(-${screenSlideIndex * 100}%)`;
    updateScreenDots();
    resetScreenSlideTimer();
}

function slideScreen(dir) {
    goToScreenSlide(screenSlideIndex + dir);
}

function updateScreenDots() {
    const dots = document.querySelectorAll('#screenSliderDots .screen-slider-dot');
    dots.forEach((d, i) => {
        d.classList.toggle('active', i === screenSlideIndex);
    });
}

function startScreenSlideTimer() {
    stopScreenSlideTimer();
    screenSlideTimer = setInterval(() => {
        goToScreenSlide(screenSlideIndex + 1);
    }, SCREEN_SLIDE_INTERVAL);
}

function stopScreenSlideTimer() {
    if (screenSlideTimer) { clearInterval(screenSlideTimer); screenSlideTimer = null; }
}

function resetScreenSlideTimer() {
    stopScreenSlideTimer();
    startScreenSlideTimer();
}

/* ─── OTHER LANYARDS SLIDER LOGIC (slide-6, slide-7) ─── */
let otherSlideIndex = 0;
let otherSlideTimer = null;
const OTHER_SLIDE_COUNT = 2;

function initOtherSlider() {
    const dotsContainer = document.getElementById('otherSliderDots');
    if (!dotsContainer) return;
    dotsContainer.innerHTML = '';
    for (let i = 0; i < OTHER_SLIDE_COUNT; i++) {
        const dot = document.createElement('span');
        dot.className = 'screen-slider-dot' + (i === 0 ? ' active' : '');
        dot.onclick = () => goToOtherSlide(i);
        dotsContainer.appendChild(dot);
    }
}

function goToOtherSlide(index) {
    otherSlideIndex = ((index % OTHER_SLIDE_COUNT) + OTHER_SLIDE_COUNT) % OTHER_SLIDE_COUNT;
    const track = document.getElementById('otherSliderTrack');
    if (track) track.style.transform = `translateX(-${otherSlideIndex * 100}%)`;
    updateOtherDots();
    resetOtherSlideTimer();
}

function slideOther(dir) {
    goToOtherSlide(otherSlideIndex + dir);
}

function updateOtherDots() {
    const dots = document.querySelectorAll('#otherSliderDots .screen-slider-dot');
    dots.forEach((d, i) => {
        d.classList.toggle('active', i === otherSlideIndex);
    });
}

function startOtherSlideTimer() {
    stopOtherSlideTimer();
    otherSlideTimer = setInterval(() => {
        goToOtherSlide(otherSlideIndex + 1);
    }, SCREEN_SLIDE_INTERVAL);
}

function stopOtherSlideTimer() {
    if (otherSlideTimer) { clearInterval(otherSlideTimer); otherSlideTimer = null; }
}

function resetOtherSlideTimer() {
    stopOtherSlideTimer();
    startOtherSlideTimer();
}

/* Show/hide slider + update page title & breadcrumb based on filter state */
function updateScreenSlider() {
    const screenSlider      = document.getElementById('screenSlider');
    const otherSlider       = document.getElementById('otherSlider');
    const badgeHolderBanner = document.getElementById('badgeHolderBanner');
    const officeBanner      = document.getElementById('officeBanner');
    const schoolBanner      = document.getElementById('schoolBanner');
    const eventBanner       = document.getElementById('eventBanner');
    const title             = document.getElementById('pageTitle');
    const subtitle          = document.getElementById('pageSubtitle');
    const breadcrumb        = document.getElementById('breadcrumbCurrent');

    const isScreenOnly = state.types.length === 1 && state.types[0] === 'screen'
                         && state.categories.length === 0 && !state.availability && state.usages.length === 0;
    const isCustomLanyards = state.categories.length === 1 && state.categories[0] === 'custom-lanyards'
                         && state.types.length === 0 && !state.availability && state.usages.length === 0;
    const isOtherLanyards  = state.categories.length === 1 && state.categories[0] === 'other-lanyards'
                         && state.types.length === 0 && !state.availability && state.usages.length === 0;
    const isBadgeHolders   = state.categories.length === 1 && state.categories[0] === 'badge-holders'
                         && state.types.length === 0 && !state.availability && state.usages.length === 0;

    const isOffice = state.usages.length === 1 && state.usages[0] === 'office'
                         && state.types.length === 0 && state.categories.length === 0 && !state.availability;
    const isSchool = state.usages.length === 1 && state.usages[0] === 'school'
                         && state.types.length === 0 && state.categories.length === 0 && !state.availability;
    const isEvent  = state.usages.length === 1 && state.usages[0] === 'event'
                         && state.types.length === 0 && state.categories.length === 0 && !state.availability;

    // Helper to hide all banners/sliders
    if (screenSlider)      screenSlider.style.display      = 'none';
    if (otherSlider)       otherSlider.style.display       = 'none';
    if (badgeHolderBanner) badgeHolderBanner.style.display = 'none';
    if (officeBanner)      officeBanner.style.display      = 'none';
    if (schoolBanner)      schoolBanner.style.display      = 'none';
    if (eventBanner)       eventBanner.style.display       = 'none';
    stopScreenSlideTimer();
    stopOtherSlideTimer();

    /* ── Sliders Display Logic ── */
    if (isScreenOnly || isCustomLanyards) {
        if (screenSlider) screenSlider.style.display = 'block';
        goToScreenSlide(0);
        startScreenSlideTimer();
    } else if (isOtherLanyards) {
        if (otherSlider) otherSlider.style.display = 'block';
        goToOtherSlide(0);
        startOtherSlideTimer();
    } else if (isBadgeHolders) {
        if (badgeHolderBanner) badgeHolderBanner.style.display = 'block';
    } else if (isOffice) {
        if (officeBanner) officeBanner.style.display = 'block';
    } else if (isSchool) {
        if (schoolBanner) schoolBanner.style.display = 'block';
    } else if (isEvent) {
        if (eventBanner) eventBanner.style.display = 'block';
    }

    /* ── Title & Breadcrumb: based on active filter ── */
    let pageName = 'สินค้าทั้งหมด';
    let pageSub  = 'ค้นหาสินค้าที่ใช่สำหรับคุณ ด้วยระบบกรองสินค้าอัจฉริยะ';

    if (state.types.length === 1 && state.types[0] === 'screen') {
        pageName = 'สายคล้องสกรีนลาย';
        pageSub  = 'สายคล้องบัตรพิมพ์ลายสกรีนตามแบบที่คุณต้องการ';
    } else if (state.types.length === 1 && state.types[0] === 'noscreen') {
        pageName = 'สายคล้องไม่สกรีนลาย';
        pageSub  = 'สายคล้องบัตรสำเร็จรูป พร้อมใช้งานทันที';
    } else if (state.categories.length === 1) {
        /* Get category display name from sidebar checkbox label */
        const catCb = document.querySelector('.sb-cat-cb[value="' + state.categories[0] + '"]');
        if (catCb) {
            const lbl = catCb.closest('.checkbox-item');
            pageName = lbl ? lbl.textContent.trim().replace(/\(\d+\)/, '').trim() : state.categories[0];
        } else {
            pageName = state.categories[0];
        }
        pageSub = 'แสดงสินค้าในหมวดหมู่ ' + pageName;
    } else if (state.availability) {
        pageName = 'สินค้าพร้อมส่ง';
        pageSub  = 'สินค้าที่มีพร้อมจัดส่งทันที';
    } else if (state.usages.length === 1) {
        const usageMap = { office: 'สำนักงานบริษัท', school: 'โรงเรียน', event: 'งานอีเว้นท์' };
        pageName = usageMap[state.usages[0]] || state.usages[0];
        pageSub  = 'สินค้าสำหรับ' + pageName;
    }

    title.textContent      = pageName;
    subtitle.textContent   = pageSub;
    breadcrumb.textContent = pageName;
}

/* Touch/swipe support for mobile */
(function() {
    const slider = document.getElementById('screenSlider');
    if (slider) {
        let touchStartX = 0, touchEndX = 0;
        slider.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
        slider.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) slideScreen(diff > 0 ? 1 : -1);
        }, { passive: true });
    }

    const otherSlider = document.getElementById('otherSlider');
    if (otherSlider) {
        let touchStartX = 0, touchEndX = 0;
        otherSlider.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
        otherSlider.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) slideOther(diff > 0 ? 1 : -1);
        }, { passive: true });
    }
})();

/* Pause auto-slide on hover */
(function() {
    const slider = document.getElementById('screenSlider');
    if (slider) {
        slider.addEventListener('mouseenter', stopScreenSlideTimer);
        slider.addEventListener('mouseleave', () => {
            if (slider.style.display !== 'none') startScreenSlideTimer();
        });
    }

    const otherSlider = document.getElementById('otherSlider');
    if (otherSlider) {
        otherSlider.addEventListener('mouseenter', stopOtherSlideTimer);
        otherSlider.addEventListener('mouseleave', () => {
            if (otherSlider.style.display !== 'none') startOtherSlideTimer();
        });
    }
})();

initScreenSlider();
initOtherSlider();

/* ══════════════════════════════════════════════════════════
   MOBILE FILTER DRAWER
   ══════════════════════════════════════════════════════════ */
function openMobileFilter() {
    const drawer  = document.getElementById('mobileFilterDrawer');
    const overlay = document.getElementById('mobileFilterOverlay');
    if (drawer)  drawer.classList.add('open');
    if (overlay) overlay.classList.add('open');
    document.body.style.overflow = 'hidden'; // lock scroll
}

function closeMobileFilter() {
    const drawer  = document.getElementById('mobileFilterDrawer');
    const overlay = document.getElementById('mobileFilterOverlay');
    if (drawer)  drawer.classList.remove('open');
    if (overlay) overlay.classList.remove('open');
    document.body.style.overflow = ''; // unlock scroll
}

function toggleMobileAcc() {
    const body    = document.getElementById('mobileAccBody');
    const trigger = document.getElementById('mobAccTrigger');
    if (!body) return;
    const isOpen = body.style.display !== 'none';
    body.style.display = isOpen ? 'none' : 'block';
    if (trigger) trigger.classList.toggle('open', !isOpen);
}

/* ══════════════════════════════════════════════════════════
   SCROLL TO TOP BUTTON
   ══════════════════════════════════════════════════════════ */
const scrollToTopBtn = document.getElementById('scrollToTop');

window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
        scrollToTopBtn.classList.add('visible');
    } else {
        scrollToTopBtn.classList.remove('visible');
    }
}, { passive: true });

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* Parse URL query params on load */
function initFromURL() {
    const params = new URLSearchParams(window.location.search);

    const cats   = [];
    const types  = [];
    const usages = [];
    let avail    = false;

    for (const [key, value] of params.entries()) {
        if (!value) continue;

        // Categories (matches category_slugs[0], category_slugs[], categories[0], category)
        if (key.startsWith('category_slugs') || key.startsWith('categories') || key === 'category') {
            if (!cats.includes(value)) cats.push(value);
        }
        // Types / Print types (matches print_types[0], types[0], types, type)
        else if (key.startsWith('print_types') || key.startsWith('types') || key === 'type') {
            let t = value;
            if (value === 'screened') t = 'screen';
            if (value === 'plain')    t = 'noscreen';
            if (!types.includes(t)) types.push(t);
        }
        // Usages / Occasions (matches occasions[0], usages[0], usages, occasion, usage)
        else if (key.startsWith('occasions') || key.startsWith('usages') || key === 'occasion' || key === 'usage') {
            if (!usages.includes(value)) usages.push(value);
        }
        // Availability
        else if ((key === 'is_ready_to_ship' && value === '1') || (key === 'availability' && value === 'true')) {
            avail = true;
        }
    }

    if (cats.length > 0 || types.length > 0 || usages.length > 0 || avail) {
        clearAllState();
        state.categories   = cats;
        state.types        = types;
        state.usages       = usages;
        state.availability = avail;

        syncAllUI();
        updateScreenSlider();
    }
}
initFromURL();
