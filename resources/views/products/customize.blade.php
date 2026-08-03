<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap');
        .cust * { box-sizing: border-box; }
        .cust { font-family: 'Prompt', sans-serif; background: #f5f5f5; min-height: 100vh; }

        /* Layout */
        .cust-main { max-width: 1100px; margin: 0 auto; padding: 24px 16px; position: relative; z-index: 10; }
        .cust-two-col { display: flex; gap: 32px; align-items: flex-start; }
        .cust-img-col { width: 380px; min-width: 380px; flex-shrink: 0; position: relative; z-index: 10; }
        .cust-form-col { flex: 1; min-width: 0; padding-bottom: 80px; }
        @media (max-width: 900px) { .cust-two-col { flex-direction: column; } .cust-img-col { width: 100%; min-width: 0; } }

        /* Image */
        .cust-img-box { width: 100%; background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 16px; aspect-ratio: 1/1; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .cust-img-box img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .cust-thumbs { display: flex; gap: 8px; margin-top: 12px; overflow-x: auto; }
        .cust-thumb { width: 60px; height: 60px; min-width: 60px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; cursor: pointer; background: #fff; padding: 0; }
        .cust-thumb.active { border: 2px solid #004998; }
        .cust-thumb img { width: 100%; height: 100%; object-fit: contain; }
        .cust-thumbs::-webkit-scrollbar { display: none; }
        .cust-thumbs { -ms-overflow-style: none; scrollbar-width: none; }

        /* Overlay */
        .cust-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 20; transition: opacity 0.3s; }

        /* Steps */
        .step-divider { font-size: 18px; font-weight: 700; color: #004998; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px dashed #e0e0e0; }
        .step-section { 
            margin-bottom: 24px; 
            position: relative; 
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .step-section:hover { border-color: #b0b0b0; }

        /* Inactive step = light gray, content fully visible */
        .step-section.inactive-step {
            background: #f0f0f0;
            border-color: #e0e0e0;
            opacity: 0.55;
        }
        .step-section.inactive-step .step-divider { color: #888; }

        /* Active step = white, blue border */
        .step-section:not(.inactive-step) {
            background: #fff;
            border-color: #004998;
            box-shadow: 0 2px 12px rgba(0,73,152,0.08);
            cursor: default;
        }
        
        .step-error { border: 2px solid #DC2626 !important; }
        .btn-close-focus { position: absolute; top: 14px; right: 14px; width: 30px; height: 30px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #333; z-index: 10; transition: background 0.2s; font-size: 15px; font-weight: 700; font-family: sans-serif; border: none; }
        .btn-close-focus:hover { background: #e0e0e0; color: #cc0000; }
        .btn-next-step { margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 16px; }
        .btn-next-step button { background: #004998; color: #fff; border: none; padding: 12px 40px; border-radius: 30px; font-weight: 600; font-size: 15px; font-family: 'Prompt', sans-serif; cursor: pointer; transition: background 0.2s; box-shadow: 0 4px 10px rgba(0,73,152,0.2); }
        .btn-next-step button:hover { background: #003675; transform: translateY(-1px); }

        /* Labels */
        .f-label { display: block; font-size: 16px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .f-select { width: 100%; max-width: 420px; border: 1px solid #ccc; border-radius: 6px; padding: 10px 14px; font-size: 16px; font-weight: 500; outline: none; font-family: 'Prompt',sans-serif; }
        .f-select:focus { border-color: #004998; box-shadow: 0 0 0 2px rgba(0,73,152,0.15); }
        .f-input { border: 1px solid #ccc; border-radius: 6px; padding: 10px 14px; font-size: 16px; outline: none; font-family: 'Prompt',sans-serif; width: 100%; max-width: 420px; }
        .f-input:focus { border-color: #004998; box-shadow: 0 0 0 2px rgba(0,73,152,0.15); }

        /* Toggle buttons (radio/checkbox styled) */
        .opt-btn { display: inline-block; padding: 8px 20px; border: 1px solid #ccc; border-radius: 20px; font-weight: 500; font-size: 15px; cursor: pointer; transition: all .15s; user-select: none; background: #fff; color: #333; }
        .opt-btn:hover { border-color: #004998; }
        .opt-btn.active { border-color: #004998; color: #004998; box-shadow: 0 0 0 1px #004998; }

        /* Color swatch blocks */
        .color-pill { display: inline-flex; align-items: center; justify-content: center; width: 135px; height: 48px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all .15s; user-select: none; color: #fff; background-size: cover; background-position: center; border: 1px solid rgba(0,0,0,0.1); }
        .color-pill.selected { box-shadow: 0 0 0 3px #004998; transform: scale(0.95); }
        .color-pill.disabled { opacity: 0.3; pointer-events: none; }

        /* Tags */
        .tag-item { display: inline-flex; align-items: center; gap: 6px; background: #FFF5F5; border: 1px solid #FECACA; color: #CC0000; padding: 4px 10px; border-radius: 4px; font-size: 14px; font-weight: 700; }
        .tag-remove { cursor: pointer; margin-left: 2px; font-size: 14px; }
        .tag-remove:hover { color: #900; }

        /* Grid for parts */
        .parts-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); gap: 8px; }
        .part-card { border: 1px solid #ddd; border-radius: 8px; padding: 8px; text-align: center; cursor: pointer; transition: all .15s; font-size: 14px; background: #fff; }
        .part-card.selected { border-color: #004998; background: #EFF6FF; }
        .part-card.selected-special { border-color: #CC0000; background: #FFF5F5; }
        .part-card img { width: 40px; height: 40px; margin: 0 auto 4px; object-fit: contain; }

        /* Clip circles */
        .clip-circle { width: 32px; height: 32px; border-radius: 50%; border: 2px solid #ddd; cursor: pointer; transition: all .15s; background: #fff; }
        .clip-circle.selected { border-color: #004998; box-shadow: 0 0 0 3px rgba(0,73,152,0.25); }

        /* Nav buttons */
        .nav-row { display: none; }

        /* Qty + summary */
        .qty-input { width: 120px; border: 1px solid #ccc; border-radius: 6px; padding: 10px; text-align: center; font-weight: 700; font-size: 16px; outline: none; font-family: 'Prompt',sans-serif; }
        .qty-input:focus { border-color: #004998; box-shadow: 0 0 0 2px rgba(0,73,152,0.15); }

        /* Action buttons */
        .btn-cart { width: 100%; max-width: 420px; padding: 14px; background: #000; color: #fff; border: none; border-radius: 6px; font-weight: 700; font-size: 16px; cursor: pointer; font-family: 'Prompt',sans-serif; display: block; text-align: center; transition: background 0.15s; margin: 0 auto; }
        .btn-cart:hover { background: #222; }
        .btn-quote { width: 100%; max-width: 420px; padding: 14px; background: #e5e5e5; color: #111; border: none; border-radius: 6px; font-weight: 700; font-size: 16px; cursor: pointer; font-family: 'Prompt',sans-serif; display: block; text-align: center; text-decoration: none; transition: background 0.15s; margin: 0 auto; }
        .btn-quote:hover { background: #d4d4d4; }
        .btn-line { width: 100%; max-width: 420px; padding: 14px; background: #06C755; color: #fff; border: none; border-radius: 6px; font-weight: 700; font-size: 16px; cursor: pointer; font-family: 'Prompt',sans-serif; display: block; text-align: center; text-decoration: none; margin: 0 auto; }
        .btn-line:hover { background: #05B04C; }

        /* Helpers - scoped to .cust to avoid Tailwind conflicts in header/footer */
        .cust .flex-row { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        .cust .text-red { color: #CC0000; }
        .cust .text-sm { font-size: 15px; }
        .cust .text-xs { font-size: 14px; }
        .cust .text-gray { color: #888; }
        .cust .mt-2 { margin-top: 8px; }
        .cust .mt-3 { margin-top: 12px; }
        .cust .mb-2 { margin-bottom: 8px; }
        .cust .mb-3 { margin-bottom: 12px; }
        .cust .hidden { display: none !important; }
    </style>

    <div x-data="customizerEngine()" class="cust">
        <!-- Main -->

        <div class="cust-main">
            <!-- Breadcrumb -->
            <nav style="font-size:15px; color:#888; margin-bottom:16px; position:relative; z-index:50;">
                <a href="{{ route('home') }}" style="color:#888;">หน้าหลัก</a> &gt;
                <a href="{{ route('products.index') }}" style="color:#888;">สินค้า</a> &gt;
                <span style="color:#333; font-weight:500;">เลือกสเปกสินค้าและขอใบเสนอราคา</span>
            </nav>
            <h1 style="font-size:26px; font-weight:700; color:#111; margin-bottom:24px; position:relative; z-index:50; text-align:center;">เลือกสเปกสินค้าและขอใบเสนอราคา</h1>


            <div class="cust-two-col">
                <!-- ═══ LEFT: Image ═══ -->
                <div class="cust-img-col">
                    <div style="position:sticky; top:160px;">
                        <div class="cust-img-box">
                            <img :src="mainImage" :alt="selectedProduct.name">
                        </div>
                        <div class="cust-thumbs">
                            <template x-for="(img, idx) in productImages" :key="idx">
                                <button @click="mainImage = img" class="cust-thumb" :class="mainImage === img ? 'active' : ''">
                                    <img :src="img">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- ═══ RIGHT: Steps ═══ -->
                <div class="cust-form-col">

                    <!-- ──────── STEP 1 ──────── -->
                    <section class="step-section" x-ref="step1" :class="activeStep !== 1 ? 'inactive-step' : ''" @click="if(activeStep !== 1) scrollToStep(1)">
                        <div class="step-divider">step 1 : เลือกแบบเชือก</div>
                        <div class="btn-close-focus" x-show="activeStep === 1" @click.stop="activeStep = null">✕</div>
                        <div style="margin-bottom:16px;">
                            <label class="f-label">ประเภทสายคล้อง</label>
                            <select x-model.number="selectedProductId" @change="onProductChange()" class="f-select">
                                <template x-for="p in allProducts" :key="p.id"><option :value="p.id" x-text="p.name"></option></template>
                            </select>
                        </div>
                        <div x-show="config.sizes.length > 0" style="margin-bottom:16px;">
                            <label class="f-label">ขนาด :</label>
                            <div class="flex-row">
                                <template x-for="size in config.sizes" :key="size">
                                    <span class="opt-btn" :class="selections.ropeSize === size ? 'active' : ''" @click="selections.ropeSize = size" x-text="size"></span>
                                </template>
                            </div>
                        </div>
                        <div x-show="config.showScreen" style="margin-bottom:16px;">
                            <label class="f-label">การสกรีน :</label>
                            <div class="flex-row">
                                <span class="opt-btn" :class="selections.screenFormat === '1side' ? 'active' : ''" @click="selections.screenFormat = '1side'">สกรีนด้านเดียว</span>
                                <span class="opt-btn" :class="selections.screenFormat === '2side' ? 'active' : ''" @click="selections.screenFormat = '2side'">สกรีนสองด้าน</span>
                            </div>
                        </div>
                        <div x-show="config.showClip" style="margin-bottom:16px;">
                            <label class="f-label">สีคลิป :</label>
                            <div class="flex-row" style="gap:16px;">
                                <span style="display:inline-flex; align-items:center; gap:6px; cursor:pointer;" @click="selections.clipColor = 'คลิปดำ'">
                                    <span class="clip-circle" :class="selections.clipColor === 'คลิปดำ' ? 'selected' : ''" style="background:#333;"></span>
                                    <span style="font-size:15px; font-weight:500;">คลิปดำ</span>
                                </span>
                                <span style="display:inline-flex; align-items:center; gap:6px; cursor:pointer;" @click="selections.clipColor = 'คลิปขาว'">
                                    <span class="clip-circle" :class="selections.clipColor === 'คลิปขาว' ? 'selected' : ''" style="background:#f0f0f0;"></span>
                                    <span style="font-size:15px; font-weight:500;">คลิปขาว</span>
                                </span>
                            </div>
                        </div>
                        <div class="btn-next-step" x-show="activeStep === 1">
                            <button type="button" @click.stop="scrollToStep(config.showStep2 ? 2 : (config.showStep3 ? 3 : 4))">ขั้นตอนถัดไป</button>
                        </div>
                    </section>
                </div> <!-- End cust-form-col -->
            </div> <!-- End cust-two-col -->

            <!-- Full Width Steps (Step 2 to 6) -->
            <div class="cust-full-width-steps" style="margin-top: 40px; max-width: 1200px; margin-left: auto; margin-right: auto;">

                    <!-- ──────── STEP 2 ──────── -->
                    <section class="step-section" x-ref="step2" x-show="config.showStep2" :class="activeStep !== 2 ? 'inactive-step' : ''" @click="if(activeStep !== 2) scrollToStep(2)">
                        <div class="step-divider">step 2: กรุณาเลือกสีเชือก</div>
                        <div class="btn-close-focus" x-show="activeStep === 2" @click.stop="activeStep = null">✕</div>
                        <!-- Jacquard text -->
                        <template x-if="config.step2Mode === 'text'">
                            <div><input type="text" x-model="selections.jacquardRopeColor" placeholder="เช่น แดงเลือดหมู, น้ำเงินกรมท่า" class="f-input"></div>
                        </template>
                        <!-- Swatch mode -->
                        <template x-if="config.step2Mode === 'swatches'">
                            <div>
                                <p class="text-sm font-bold text-gray-700 mb-2">step 2.1: สีปกติ <span class="font-normal">(คละสีได้มากสุด 5 สี ตั้งแต่สีที่ 2 ขึ้นไปมีค่าใช้จ่ายเพิ่ม 300 บาทต่อสี/การสั่งซื้อ)</span></p>
                                <div class="flex-row">
                                    <template x-for="color in standardColors" :key="color.name">
                                        <span class="color-pill" :class="{ 'selected': selections.ropeColors.includes(color.name), 'disabled': !selections.ropeColors.includes(color.name) && selections.ropeColors.length >= 5 }"
                                              :style="'background-image: url(\'/images/colors custome/' + color.img + '\')'"
                                              @click="toggleRopeColor(color.name)">
                                        </span>
                                    </template>
                                </div>
                                <p class="text-xs text-gray mt-2">เลือกแล้ว <b x-text="selections.ropeColors.length"></b>/5 สี
                                    <template x-if="selections.ropeColors.length > 1"><span class="text-red" style="font-weight:700; margin-left:4px;">+฿<span x-text="(selections.ropeColors.length - 1) * 300"></span></span></template>
                                </p>
                                <!-- Special colors -->
                                <div style="padding-top:12px; border-top:1px solid #eee; margin-top:12px;">
                                    <p class="text-sm font-bold text-gray-700 mb-2">step 2.2: สีเชือกพิเศษ <span class="font-normal">(มีค่าใช้จ่ายสีละ 1500 บาท/การสั่งซื้อ) (กรุณาระบุสีที่ต้องการตาม Pantone หากไม่มีสีที่คุณต้องการในตารางสี)</span></p>
                                    <div class="flex-row mb-2">
                                        <span class="opt-btn" :class="selections.wantSpecialRopeColor ? 'active' : ''" @click="selections.wantSpecialRopeColor = true">ต้องการ</span>
                                        <span class="opt-btn" :class="!selections.wantSpecialRopeColor ? 'active' : ''" @click="selections.wantSpecialRopeColor = false">ไม่ต้องการ</span>
                                    </div>
                                    <div x-show="selections.wantSpecialRopeColor">
                                        <div style="display:flex; gap:8px; max-width:420px; align-items:center;">
                                            <input type="text" x-model="newSpecialRopeColor" placeholder="เช่น Pantone 295C" class="f-input" style="flex:1;" @keydown.enter.prevent="addSpecialRopeColor()">
                                            <button @click="addSpecialRopeColor()" x-show="selections.specialRopeColors.length < 3" style="padding:10px 20px; background:#004998; color:#fff; border:none; border-radius:6px; font-size:20px; font-weight:700; cursor:pointer; line-height:1; display:flex; align-items:center; justify-content:center; min-width:48px; transition:background 0.15s;" onmouseover="this.style.background='#003774'" onmouseout="this.style.background='#004998'">+</button>
                                        </div>
                                        <p class="text-xs text-gray mt-1">เพิ่มได้มากสุด 3 สี (เพิ่มแล้ว <b x-text="selections.specialRopeColors.length"></b>/3)</p>
                                        <div class="flex-row mt-2">
                                            <template x-for="(sc, idx) in selections.specialRopeColors" :key="idx">
                                                <span class="tag-item"><span x-text="sc"></span> <span class="text-xs">(+฿1,500)</span> <span class="tag-remove" @click="selections.specialRopeColors.splice(idx, 1)">×</span></span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="btn-next-step" x-show="activeStep === 2">
                            <button type="button" @click.stop="scrollToStep(config.showStep3 ? 3 : 4)">ขั้นตอนถัดไป</button>
                        </div>
                    </section>

                    <!-- ──────── STEP 3 ──────── -->
                    <section class="step-section" x-ref="step3" x-show="config.showStep3" :class="activeStep !== 3 ? 'inactive-step' : ''" @click="if(activeStep !== 3) scrollToStep(3)">
                        <div class="step-divider">step 3: กรุณาเลือกสีสกรีน<span style="font-size:14px; font-weight:400; color:#666;">(สกรีนได้มากสุด 6 สี ค่าใช้จ่ายสีละ 1000 บาท/การสั่งซื้อ สีสกรีนพื้นฐานจะเป็นสีขาวหากลูกค้าไม่เลือกสีอื่น)</span></div>
                        <div class="btn-close-focus" x-show="activeStep === 3" @click.stop="activeStep = null">✕</div>
                        <template x-if="config.step3Mode === 'text'">
                            <div><input type="text" x-model="selections.jacquardLogoColor" placeholder="เช่น สีขาว, สีทอง" class="f-input"></div>
                        </template>
                        <template x-if="config.step3Mode === 'swatches'">
                            <div>
                                <div class="flex-row mb-3">
                                    <span class="opt-btn" :class="selections.wantScreenColor ? 'active' : ''" @click="selections.wantScreenColor = true">ต้องการสีอื่น</span>
                                    <span class="opt-btn" :class="!selections.wantScreenColor ? 'active' : ''" @click="selections.wantScreenColor = false; selections.screenColorFields = []">ไม่ต้องการสีอื่น</span>
                                </div>
                                <div x-show="selections.wantScreenColor">
                                    <div style="display:flex; gap:8px; max-width:420px; align-items:center;">
                                        <input type="text" x-model="newScreenColor" placeholder="เช่น สีทอง, Pantone 123C" class="f-input" style="flex:1;" @keydown.enter.prevent="addScreenColor()">
                                        <button @click="addScreenColor()" x-show="selections.screenColorFields.length < 6" style="padding:10px 20px; background:#004998; color:#fff; border:none; border-radius:6px; font-size:20px; font-weight:700; cursor:pointer; line-height:1; display:flex; align-items:center; justify-content:center; min-width:48px;" onmouseover="this.style.background='#003774'" onmouseout="this.style.background='#004998'">+</button>
                                    </div>
                                    <p class="text-xs text-gray mt-1">เพิ่มได้มากสุด 6 สี (เพิ่มแล้ว <b x-text="selections.screenColorFields.length"></b>/6)</p>
                                    <!-- Validation error -->
                                    <p x-show="screenFieldError" style="color:#DC2626; font-size:16px; font-weight:600; margin-top:8px;">⚠ กรุณาเพิ่มสีอย่างน้อย 1 สี</p>
                                    <!-- Tags -->
                                    <div class="flex-row mt-2">
                                        <template x-for="(sc, idx) in selections.screenColorFields" :key="idx">
                                            <span class="tag-item"><span x-text="sc"></span> <span class="text-xs">(+฿1,000)</span> <span class="tag-remove" @click="selections.screenColorFields.splice(idx, 1)">×</span></span>
                                        </template>
                                    </div>
                                    <!-- Summary -->
                                    <p x-show="selections.screenColorFields.length > 0" class="text-xs mt-2" style="color:#004998; font-weight:600;">
                                        ค่าสีสกรีน: <span x-text="selections.screenColorFields.length"></span> สี × ฿1,000 = <span class="text-red" style="font-weight:700;" x-text="'฿' + (selections.screenColorFields.length * 1000).toLocaleString()"></span>
                                    </p>
                                </div>
                            </div>
                        </template>
                        <div class="btn-next-step" x-show="activeStep === 3">
                            <button type="button" @click.stop="scrollToStep(4)">ขั้นตอนถัดไป</button>
                        </div>
                    </section>

                    <!-- ──────── STEP 4 ──────── -->
                    <section class="step-section" x-ref="step4" :class="activeStep !== 4 ? 'inactive-step' : ''" @click="if(activeStep !== 4) scrollToStep(4)">
                        <div class="step-divider">step 4: กรุณาเลือกพาร์ท</div>
                        <div class="btn-close-focus" x-show="activeStep === 4" @click.stop="activeStep = null">✕</div>
                        <p x-show="!isYoyo" class="text-sm font-bold text-gray-700 mb-2">step 4.1: ส่วนประกอบเชือก <span class="font-normal">(กรุณาเลือก free part, other part หรือ yoyo part อย่างน้อย 1 ชนิด)</span></p>
                        <!-- Free+Other Parts (non-yoyo) -->
                        <template x-if="config.showFreeParts && !isYoyo">
                            <div>
                                <p class="f-label">Free Part (ส่วนประกอบฟรี) :</p>
                                <div class="parts-grid mb-3">
                                    <template x-for="part in freeParts" :key="part.id">
                                        <div class="part-card" :class="selections.selectedFreeParts.includes(part.id) ? 'selected' : ''" @click="selections.selectedFreeParts = selections.selectedFreeParts.includes(part.id) ? [] : [part.id]; selections.selectedOtherParts = []; selections.optionalYoyoType = '';">
                                            <img :src="part.primary_image ? '/'+part.primary_image.image_path : '/images/no-image.svg'">
                                            <div style="font-weight:500; line-height:1.2;" x-text="part.name"></div>
                                        </div>
                                    </template>
                                </div>
                                <p class="f-label">Other Part (ส่วนประกอบอื่นๆ) :</p>
                                <div class="parts-grid">
                                    <template x-for="part in otherParts" :key="part.id">
                                        <div class="part-card" :class="selections.selectedOtherParts.includes(part.id) ? 'selected' : ''" @click="selections.selectedOtherParts = selections.selectedOtherParts.includes(part.id) ? [] : [part.id]; selections.selectedFreeParts = []; selections.optionalYoyoType = '';">
                                            <img :src="part.primary_image ? '/'+part.primary_image.image_path : '/images/no-image.svg'">
                                            <div style="font-weight:500; line-height:1.2;" x-text="part.name"></div>
                                            <div class="text-red" style="font-size:10px; font-weight:700;" x-text="'฿' + getPartCustomPrice(part.id)"></div>
                                        </div>
                                    </template>
                                </div>
                                <div style="margin-top:20px; border-top:1px dashed #ccc; padding-top:12px;">
                                    <p class="f-label" style="text-align:center;">:: YoYo part (ดูข้อมูลเพิ่มเติม) ::</p>
                                    <div style="margin-bottom:12px;">
                                        <label class="f-label">เลือกประเภทโยโย่ :</label>
                                        <select x-model="selections.optionalYoyoType" @change="if(selections.optionalYoyoType) { selections.selectedFreeParts = []; selections.selectedOtherParts = []; }" class="f-select">
                                            <option value="">:: เลือกประเภทโยโย่ ::</option>
                                            <option value="bw">โยโย่ขาว-ดำ</option>
                                            <option value="black">โยโย่ดำ</option>
                                            <option value="color">โยโย่สี (คาราบิเนอร์)</option>
                                        </select>
                                    </div>
                                    <div x-show="selections.optionalYoyoType === 'bw'" style="margin-bottom:12px;">
                                        <p class="text-xs text-gray" style="margin-bottom:8px; line-height:1.4;">ความยาวสาย: 60 cm (ติดสติกเกอร์โลโก้บริษัทได้)</p>
                                        <label class="f-label">สี :</label>
                                        <div class="flex-row">
                                            <span class="opt-btn" :class="selections.optionalYoyoColor === 'สีดำ' ? 'active' : ''" @click="selections.optionalYoyoColor = 'สีดำ'">สีดำ</span>
                                            <span class="opt-btn" :class="selections.optionalYoyoColor === 'สีขาว' ? 'active' : ''" @click="selections.optionalYoyoColor = 'สีขาว'" style="background:#f0f0f0;">สีขาว</span>
                                        </div>
                                    </div>
                                    <div x-show="selections.optionalYoyoType === 'black'" style="margin-bottom:12px;">
                                        <p class="text-xs text-gray" style="line-height:1.4;">สีดำทึบ (ติดสติกเกอร์ไม่ได้)<br>ความยาวสาย: 70 cm</p>
                                    </div>
                                    <div x-show="selections.optionalYoyoType === 'color'" style="margin-bottom:12px;">
                                        <p class="text-xs text-gray" style="margin-bottom:8px; line-height:1.4;">มีสีให้เลือกหลากหลาย (เช่น สีขาวทึบ, สีดำทึบ, สีแดงทึบ และแบบโปร่งใส เช่น สีดำ, น้ำเงิน, ฟ้า, เขียว, เหลือง, ม่วง, แดง)<br>ความยาวสาย: 60 cm (ติดสติกเกอร์โลโก้บริษัทได้)</p>
                                        <label class="f-label">สี :</label>
                                        <select x-model="selections.optionalYoyoColor" class="f-select">
                                            <template x-for="c in yoyoColorOptions" :key="c"><option :value="c" x-text="c"></option></template>
                                        </select>
                                    </div>
                                    <div x-show="selections.optionalYoyoType && selections.optionalYoyoType !== 'black'" style="margin-bottom:12px;">
                                        <label class="f-label">ต้องการสติ๊กเกอร์โลโก้ :</label>
                                        <div class="flex-row">
                                            <span class="opt-btn" :class="selections.optionalYoyoSticker ? 'active' : ''" @click="selections.optionalYoyoSticker = true">ต้องการ</span>
                                            <span class="opt-btn" :class="!selections.optionalYoyoSticker ? 'active' : ''" @click="selections.optionalYoyoSticker = false">ไม่ต้องการ</span>
                                        </div>
                                    </div>
                                    <div x-show="selections.optionalYoyoType" style="background:#f9f9f9; padding:12px; border-radius:6px; font-size:15px; color:#666;">
                                        ราคาโยโย่: <b style="color:#004998;" x-text="'฿' + yoyoUnitPrice.toFixed(2) + '/ชิ้น'"></b> *ยิ่งซื้อมากยิ่งถูก
                                    </div>
                                </div>
                            </div>
                        </template>
                        <!-- YoYo -->
                        <template x-if="isYoyo">
                            <div>
                                <p class="f-label">เลือกโยโย่ : <span class="text-xs text-gray" style="font-weight:400;">ส่วนประกอบพิเศษ (มีค่าบริการ)</span></p>
                                <h4 style="font-size:15px; font-weight:700; color:#004998; margin:10px 0 6px;">กลุ่มโยโย่มาตรฐาน และ สต็อปเปอร์ (Standard & Stopper)</h4>
                                <div class="parts-grid mb-3">
                                    <template x-for="part in yoyoPartsData.filter(p => p.name.includes('โยโย่ดำ') || p.name.includes('โยโย่ขาว') || p.name.includes('สต๊อปเปอร์'))" :key="part.id">
                                        <div class="part-card" :class="selections.selectedYoyoId === part.id ? 'selected' : ''" @click="selections.selectedYoyoId = part.id">
                                            <img :src="part.primary_image ? '/'+part.primary_image.image_path : '/images/no-image.svg'">
                                            <div style="font-weight:500; line-height:1.2; font-size:16px;" x-text="part.name"></div>
                                        </div>
                                    </template>
                                </div>
                                <h4 style="font-size:15px; font-weight:700; color:#004998; margin:10px 0 6px;">กลุ่มคาราบิเนอร์โยโย่ - แบบสีทึบ (Carabiner Solid Color)</h4>
                                <div class="parts-grid mb-3">
                                    <template x-for="part in yoyoPartsData.filter(p => p.name.includes('ทึบ'))" :key="part.id">
                                        <div class="part-card" :class="selections.selectedYoyoId === part.id ? 'selected' : ''" @click="selections.selectedYoyoId = part.id">
                                            <img :src="part.primary_image ? '/'+part.primary_image.image_path : '/images/no-image.svg'">
                                            <div style="font-weight:500; line-height:1.2; font-size:16px;" x-text="part.name"></div>
                                        </div>
                                    </template>
                                </div>
                                <h4 style="font-size:15px; font-weight:700; color:#004998; margin:10px 0 6px;">กลุ่มคาราบิเนอร์โยโย่ - แบบสีโปร่งใส (Carabiner Transparent Color)</h4>
                                <div class="parts-grid mb-3">
                                    <template x-for="part in yoyoPartsData.filter(p => p.name.includes('โปร่งใส'))" :key="part.id">
                                        <div class="part-card" :class="selections.selectedYoyoId === part.id ? 'selected' : ''" @click="selections.selectedYoyoId = part.id">
                                            <img :src="part.primary_image ? '/'+part.primary_image.image_path : '/images/no-image.svg'">
                                            <div style="font-weight:500; line-height:1.2; font-size:16px;" x-text="part.name"></div>
                                        </div>
                                    </template>
                                </div>
                                <div x-show="selections.selectedYoyoId && yoyoPartsData.find(p => p.id === selections.selectedYoyoId) && !yoyoPartsData.find(p => p.id === selections.selectedYoyoId).name.includes('สต๊อปเปอร์')" style="margin-bottom:12px;">
                                    <label class="f-label">ต้องการสติ๊กเกอร์โลโก้บนโยโย่ :</label>
                                    <div class="flex-row">
                                        <span class="opt-btn" :class="selections.yoyoSticker ? 'active' : ''" @click="selections.yoyoSticker = true">ต้องการ</span>
                                        <span class="opt-btn" :class="!selections.yoyoSticker ? 'active' : ''" @click="selections.yoyoSticker = false">ไม่ต้องการ</span>
                                    </div>
                                </div>
                                <div x-show="selections.selectedYoyoId" style="background:#f9f9f9; padding:12px; border-radius:6px; font-size:15px; color:#666;">ราคาโยโย่: <b style="color:#004998;" x-text="'฿' + yoyoUnitPrice.toFixed(2) + '/ชิ้น'"></b> *ยิ่งซื้อมากยิ่งถูก</div>
                            </div>
                        </template>
                        <!-- Special Parts -->
                        <div x-show="!isYoyo" style="margin-top:24px; padding-top:20px; border-top:1px solid #eee;">
                            <p class="text-sm font-bold text-gray-700 mb-2">step 4.2: ส่วนประกอบพิเศษ <span class="font-normal">(ส่วนประกอบพิเศษมีค่าบริการ)</span></p>
                            <div class="flex-row mb-2">
                                <span class="opt-btn" :class="selections.wantSpecialParts ? 'active' : ''" @click="selections.wantSpecialParts = true">ต้องการ</span>
                                <span class="opt-btn" :class="!selections.wantSpecialParts ? 'active' : ''" @click="selections.wantSpecialParts = false">ไม่ต้องการ</span>
                            </div>
                            <div x-show="selections.wantSpecialParts">
                                <div class="parts-grid">
                                    <template x-for="part in specialParts" :key="part.id">
                                        <div class="part-card" :class="selections.selectedSpecialParts.includes(part.id) ? 'selected-special' : ''" @click="toggleArray(selections.selectedSpecialParts, part.id)">
                                            <img :src="part.primary_image ? '/'+part.primary_image.image_path : '/images/no-image.svg'">
                                            <div style="font-weight:500; line-height:1.2;" x-text="part.name"></div>
                                            <div class="text-red" style="font-size:10px; font-weight:700;" x-text="'฿' + getPartCustomPrice(part.id) + '/ชิ้น'"></div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="btn-next-step" x-show="activeStep === 4">
                            <button type="button" @click.stop="scrollToStep(5)">ขั้นตอนถัดไป</button>
                        </div>
                    </section>

                    <!-- ──────── STEP 5 ──────── -->
                    <section class="step-section" x-ref="step5" :class="activeStep !== 5 ? 'inactive-step' : ''" @click="if(activeStep !== 5) scrollToStep(5)">
                        <div class="step-divider">step 5: ซองใส่บัตรพนักงาน</div>
                        <div class="btn-close-focus" x-show="activeStep === 5" @click.stop="activeStep = null">✕</div>
                        <div class="flex-row mb-3">
                            <span class="opt-btn" :class="selections.wantCardHolder ? 'active' : ''" @click="selections.wantCardHolder = true">ต้องการ (ซองละเริ่ม ฿15)</span>
                            <span class="opt-btn" :class="!selections.wantCardHolder ? 'active' : ''" @click="selections.wantCardHolder = false">ไม่ต้องการ</span>
                        </div>
                        <div x-show="selections.wantCardHolder">
                            <label class="f-label">เลือกประเภทซองใส่บัตร :</label>
                            <select x-model="selections.cardHolder" class="f-select">
                                <option value="">:: กรุณาเลือก ::</option>
                                <template x-for="group in cardHolderGroups" :key="group.label">
                                    <optgroup :label="group.label">
                                        <template x-for="c in group.items" :key="c.id">
                                            <option :value="c.id" x-text="c.name + ' (+฿' + parseInt(c.base_price) + ')'"></option>
                                        </template>
                                    </optgroup>
                                </template>
                            </select>
                            <div x-show="selections.cardHolder" class="mt-3" style="text-align:center;">
                                <img :src="cardHoldersData.find(x => x.id == selections.cardHolder)?.primary_image ? '/' + cardHoldersData.find(x => x.id == selections.cardHolder).primary_image.image_path : '/images/no-image.svg'"
                                     style="max-width:200px; max-height:200px; border-radius:8px; border:1px solid #ccc; background:#fff; object-fit:contain; padding:4px;">
                            </div>
                        </div>
                        <div class="btn-next-step" x-show="activeStep === 5">
                            <button type="button" @click.stop="scrollToStep(6)">ขั้นตอนถัดไป</button>
                        </div>
                    </section>

                    <!-- ──────── STEP 6 ──────── -->
                    <section class="step-section" x-ref="step6" :class="activeStep !== 6 ? 'inactive-step' : ''" @click="if(activeStep !== 6) scrollToStep(6)">
                        <div class="step-divider">สรุปรายละเอียดเพิ่มเติม</div>
                        <div class="btn-close-focus" x-show="activeStep === 6" @click.stop="activeStep = null">✕</div>
                        <!-- Quantity -->
                        <div style="margin-bottom:16px;">
                            <label class="f-label">จำนวนสินค้าที่ต้องการ :</label>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <input type="number" x-model.number="selections.quantity" min="20" class="qty-input">
                                <span class="text-sm text-gray">เส้น</span>
                            </div>
                            <div x-show="selections.quantity > 50000" style="margin-top:8px; padding:10px; background:#FEF2F2; border:1px solid #FECACA; border-radius:6px; font-size:15px; color:#DC2626; font-weight:700;">
                                ⚠ จำนวนมากกว่า 50,000 เส้น กรุณาติดต่อแอดมิน
                            </div>
                        </div>
                        <!-- Sample -->
                        <div style="margin-bottom:16px;">
                            <label class="f-label">ตัวอย่างสินค้า :</label>
                            <div class="flex-row">
                                <span class="opt-btn" :class="selections.needSample ? 'active' : ''" @click="selections.needSample = true">ต้องการ</span>
                                <span class="opt-btn" :class="!selections.needSample ? 'active' : ''" @click="selections.needSample = false">ไม่ต้องการ</span>
                            </div>
                        </div>
                        <!-- Express -->
                        <div style="margin-bottom:16px;">
                            <label class="f-label">การจัดส่ง :</label>
                            <div class="flex-row mb-2">
                                <span class="opt-btn" :class="selections.needExpress ? 'active' : ''" @click="selections.needExpress = true">แบบเร่งด่วน</span>
                                <span class="opt-btn" :class="!selections.needExpress ? 'active' : ''" @click="selections.needExpress = false">แบบปกติ (ฟรี)</span>
                            </div>
                            <div class="text-xs text-gray">
                                <p>• ส่งปกติ 14-18 วันทำการ (ฟรี)</p>
                                <p class="text-red">• ส่งด่วน 7-10 วันทำการ (<span x-text="expressDeliveryLabel"></span>)</p>
                            </div>
                        </div>
                        <!-- Price summary table -->
                        <div style="border:1px solid #e5e7eb; border-radius:8px; overflow:hidden; margin-bottom:16px;">
                            <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
                            <table style="width:100%; border-collapse:collapse; font-size:14px; min-width:420px;">
                                <thead>
                                    <tr style="background:#f8f9fa;">
                                        <th style="padding:10px 10px; text-align:left; border-bottom:1px solid #e5e7eb; font-weight:600; color:#333;">รายการ</th>
                                        <th style="padding:10px 8px; text-align:right; border-bottom:1px solid #e5e7eb; font-weight:600; color:#333; white-space:nowrap;">ราคา/หน่วย</th>
                                        <th style="padding:10px 8px; text-align:right; border-bottom:1px solid #e5e7eb; font-weight:600; color:#333; white-space:nowrap;">จำนวน</th>
                                        <th style="padding:10px 10px; text-align:right; border-bottom:1px solid #e5e7eb; font-weight:600; color:#333; white-space:nowrap;">รวม (฿)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(line, idx) in buildLineItems" :key="idx">
                                        <tr :style="idx % 2 === 1 ? 'background:#fafafa' : ''">
                                            <td style="padding:8px 10px; border-bottom:1px solid #f0f0f0;" x-text="line.item"></td>
                                            <td style="padding:8px 8px; border-bottom:1px solid #f0f0f0; text-align:right; white-space:nowrap;" x-text="line.unit_cost.toLocaleString(undefined, {minimumFractionDigits:0, maximumFractionDigits:2})"></td>
                                            <td style="padding:8px 8px; border-bottom:1px solid #f0f0f0; text-align:right; white-space:nowrap;" x-text="line.qty.toLocaleString()"></td>
                                            <td style="padding:8px 10px; border-bottom:1px solid #f0f0f0; text-align:right; font-weight:600; white-space:nowrap;" x-text="line.total.toLocaleString(undefined, {minimumFractionDigits:0, maximumFractionDigits:2})"></td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tfoot>
                                    <tr style="background:#f0f4f8;">
                                        <td colspan="3" style="padding:12px 10px; text-align:right; font-weight:700; color:#004998; font-size:16px; white-space:nowrap;">ราคารวม (ยังไม่รวม VAT)</td>
                                        <td style="padding:12px 10px; text-align:right; font-weight:700; color:#CC0000; font-size:16px; white-space:nowrap;" x-text="'฿' + grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2})"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                        <p style="font-size:16px; color:#888; margin-bottom:16px; font-style:italic;">* ราคานี้ยังไม่รวม VAT 7% — VAT จะคำนวณในใบเสนอราคา</p>
                        <!-- Buttons -->
                        <div style="margin-top:24px;">
                            <button x-show="selections.quantity <= 50000" @click="submitToCart" class="btn-cart" style="margin-bottom:12px;">เพิ่มลงตะกร้า</button>
                            <a x-show="selections.quantity > 50000" href="https://line.me/" target="_blank" class="btn-line" style="margin-bottom:12px;">ติดต่อแอดมิน</a>
                            <button type="button" @click="requestQuotation" class="btn-quote" style="padding:12px;">ขอใบเสนอราคา</button>
                        </div>
                        <div style="margin-top:12px;" x-show="activeStep === 6">
                            <button class="nav-back" @click="prevStep()">← ย้อนกลับ</button>
                        </div>
                        <div class="click-overlay" x-show="activeStep > 0 && activeStep !== 6" @click.stop="activeStep = 6"></div>
                    </section>
            </div> <!-- End cust-full-width-steps -->
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('customizerEngine', () => ({
            allProducts: @json($allCustomProducts),
            partsData: @json($parts),
            yoyoPartsData: @json($yoyoParts),
            cardHoldersData: @json($cardHolders),
            rates: @json($customRates),

            selectedProductId: {{ $product->id }},
            activeStep: 1,

            scrollToStep(step) {
                this.activeStep = step;
                this.$nextTick(() => {
                    const ref = this.$refs['step' + step];
                    if (ref) {
                        ref.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            },
            mainImage: '{{ $product->primaryImage ? asset($product->primaryImage->image_path) : asset("images/no-image.svg") }}',
            newSpecialRopeColor: '',
            newScreenColor: '',
            screenFieldError: false,
            editCartItemId: {{ $editCartItemId ?? 'null' }},

            selections: {
                ropeSize: '15mm', screenFormat: '1side', clipColor: 'คลิปดำ',
                ropeColors: [], wantSpecialRopeColor: false, specialRopeColors: [],
                jacquardRopeColor: '', jacquardLogoColor: '',
                wantScreenColor: false, screenColorFields: [],
                selectedFreeParts: [], selectedOtherParts: [], selectedSpecialParts: [],
                wantSpecialParts: false, wantCardHolder: false, cardHolder: '',
                selectedYoyoId: 67, yoyoSticker: false,
                optionalYoyoType: '', optionalYoyoColor: 'สีดำ', optionalYoyoSticker: false,
                quantity: 100, needSample: false, needExpress: false,
            },

            FREE_PART_IDS: [82, 83, 84, 85, 86],
            OTHER_PART_IDS: [90, 91, 88, 89, 100, 98, 92, 93],
            SPECIAL_PART_IDS: [96, 97, 103, 101, 104, 102, 105, 118, 119, 120],

            TYPE_CONFIG: @json($typeConfigs),

            standardColors: [
                {name:'Flag Red',hex:'#CE1126',label:'Flag Red',img:'4.jpg'},
                {name:'361 C',hex:'#DA291C',label:'361 C',img:'2.jpg'},
                {name:'Reflex Blue',hex:'#001489',label:'Reflex Blue',img:'3.jpg'},
                {name:'485 C',hex:'#DA291C',label:'485 C',img:'1.jpg'},
                {name:'Orange C',hex:'#FF6A13',label:'Orange C',img:'5.jpg'},
                {name:'208 C',hex:'#8A1538',label:'208 C',img:'6.jpg'},
                {name:'Purple C',hex:'#BB29BB',label:'Purple C',img:'7.jpg'},
                {name:'2607 C',hex:'#500778',label:'2607 C',img:'8.jpg'},
                {name:'1235 C',hex:'#FFB81C',label:'1235 C',img:'9.jpg'},
                {name:'Yellow C',hex:'#FEDD00',label:'Yellow C',img:'10.jpg'},
                {name:'1905 C',hex:'#F8B9D4',label:'1905 C',img:'11.jpg'},
                {name:'478 C',hex:'#4E3629',label:'478 C',img:'12.jpg'},
                {name:'382 C',hex:'#C4D600',label:'382 C',img:'13.jpg'},
                {name:'348 C',hex:'#00843D',label:'348 C',img:'14.jpg'},
                {name:'Process Blue',hex:'#0085CA',label:'Process Blue',img:'15.jpg'},
                {name:'293 C',hex:'#003DA5',label:'293 C',img:'16.jpg'},
                {name:'232 C',hex:'#F04E98',label:'232 C',img:'17.jpg'},
                {name:'Cool Gray 6C',hex:'#A7A8AA',label:'Cool Gray 6C',img:'18.jpg'},
                {name:'Black',hex:'#000000',label:'Black',img:'19.jpg'},
                {name:'White',hex:'#FFFFFF',label:'White',img:'20.jpg'},
                {name:'Navy',hex:'#002855',label:'Navy',img:'21.jpg'},
                {name:'Dark Blue',hex:'#00205B',label:'Dark Blue',img:'22.jpg'},
            ],

            yoyoColorOptions: ['สีขาวทึบ','สีดำทึบ','สีแดงทึบ','สีดำโปร่งใส','สีน้ำเงินโปร่งใส','สีฟ้าโปร่งใส','สีเขียวโปร่งใส','สีเหลืองโปร่งใส','สีม่วงโปร่งใส','สีแดงโปร่งใส'],

            get config() { return this.TYPE_CONFIG[this.selectedProductId] || this.TYPE_CONFIG[2]; },
            get selectedProduct() { return this.allProducts.find(p => p.id === this.selectedProductId) || this.allProducts[0]; },
            get productImages() { let p = this.selectedProduct; if (!p?.images?.length) return ['/images/no-image.svg']; return p.images.map(img => '/' + img.image_path); },
            get isYoyo() { return this.selectedProductId === 9; },
            get freeParts() { return this.partsData.filter(p => this.FREE_PART_IDS.includes(p.id)); },
            get otherParts() { return this.partsData.filter(p => this.OTHER_PART_IDS.includes(p.id)); },
            get specialParts() { 
                let baseSpecial = this.partsData.filter(p => this.SPECIAL_PART_IDS.includes(p.id));
                let allowed = this.config.allowedSpecial || [];
                if (allowed.length === 0) return [];
                return baseSpecial.filter(p => allowed.some(a => p.name.includes(a)));
            },
            get cardHolderGroups() {
                let ch = this.cardHoldersData;
                return [
                    { label: 'ซองอ่อน (STD)', items: ch.filter(c => c.name.includes('STD')) },
                    { label: 'ซองอ่อน (N / NZ)', items: ch.filter(c => (c.name.includes('_N(') || c.name.includes('_NZ(')) && !c.name.includes('STD')) },
                    { label: 'ซองหนัง (PU)', items: ch.filter(c => c.name.includes('_PU_')) },
                    { label: 'ซองเลื่อน (Sliding)', items: ch.filter(c => c.name.includes('Sliding') || c.name.includes('ID_CARD')) },
                    { label: 'กรอบแข็ง (F)', items: ch.filter(c => /^F\d{3}/.test(c.name)) },
                ];
            },

            // ── Pricing ──
            getRatePrice(scope, scopeKey, qty) {
                let tiers = this.rates[scope]?.[scopeKey];
                if (!tiers) return 0;
                let perUnitTiers = tiers.filter(t => t.fee_type === 'per_unit').sort((a,b) => b.min_qty - a.min_qty);
                let matched = perUnitTiers.find(t => qty >= t.min_qty);
                return matched ? matched.price : (perUnitTiers.length > 0 ? perUnitTiers[perUnitTiers.length - 1].price : 0);
            },
            getFlatFee(scope, scopeKey) {
                let tiers = this.rates[scope]?.[scopeKey];
                if (!tiers) return 0;
                let flat = tiers.find(t => t.fee_type === 'flat');
                return flat ? flat.price : 0;
            },
            get ropeUnitPrice() {
                let sides = this.config.showScreen ? this.selections.screenFormat : '1side';
                return this.getRatePrice('rope', `${this.selectedProductId}_${this.selections.ropeSize}_${sides}`, this.selections.quantity);
            },
            get yoyoUnitPrice() {
                if (this.isYoyo) {
                    if (!this.selections.selectedYoyoId) return 0;
                    let p = this.yoyoPartsData.find(x => x.id === this.selections.selectedYoyoId);
                    if (!p) return 0;
                    let type = p.name.includes('สต๊อปเปอร์') ? 'black' : (p.name.includes('คาราบิเนอร์') ? 'color' : 'bw');
                    let key = type === 'black' ? 'black' : (type === 'bw' ? (this.selections.yoyoSticker ? 'bw_sticker' : 'bw_no_sticker') : (this.selections.yoyoSticker ? 'color_sticker' : 'color_no_sticker'));
                    return this.getRatePrice('yoyo', key, this.selections.quantity);
                } else {
                    if (!this.selections.optionalYoyoType) return 0;
                    let type = this.selections.optionalYoyoType;
                    let key = type === 'black' ? 'black' : (type === 'bw' ? (this.selections.optionalYoyoSticker ? 'bw_sticker' : 'bw_no_sticker') : (this.selections.optionalYoyoSticker ? 'color_sticker' : 'color_no_sticker'));
                    return this.getRatePrice('yoyo', key, this.selections.quantity);
                }
            },
            get partsUnitPrice() {
                let price = 0;
                this.selections.selectedOtherParts.forEach(id => { price += this.getRatePrice('part', `other_${id}`, this.selections.quantity); });
                if (this.selections.wantSpecialParts) {
                    this.selections.selectedSpecialParts.forEach(id => {
                        let p = this.getRatePrice('part', `special_${id}`, this.selections.quantity);
                        if (p === 0) { let part = this.partsData.find(x => x.id == id); p = part ? parseFloat(part.base_price) : 0; }
                        price += p;
                    });
                }
                return price;
            },
            get cardHolderUnitPrice() {
                if (!this.selections.wantCardHolder || !this.selections.cardHolder) return 0;
                let ch = this.cardHoldersData.find(x => x.id == this.selections.cardHolder);
                return ch ? parseFloat(ch.base_price) : 0;
            },
            getPartCustomPrice(partId) {
                let key = this.FREE_PART_IDS.includes(partId) ? `free_${partId}` : this.OTHER_PART_IDS.includes(partId) ? `other_${partId}` : `special_${partId}`;
                let price = this.getRatePrice('part', key, this.selections.quantity);
                if (price === 0 && !this.FREE_PART_IDS.includes(partId)) { let part = this.partsData.find(x => x.id == partId); return part ? parseFloat(part.base_price).toFixed(0) : '0'; }
                return price.toFixed(0);
            },
            get addedFees() {
                let fees = [];
                fees.push({ name: 'ค่าบล็อกสกรีน', amount: this.getFlatFee('screen_block', 'all') });
                if (this.selections.ropeColors.length > 1) fees.push({ name: `ค่าคละสี (${this.selections.ropeColors.length - 1} สี)`, amount: (this.selections.ropeColors.length - 1) * this.getFlatFee('rope_color', 'extra_standard') });
                if (this.selections.wantSpecialRopeColor && this.selections.specialRopeColors.length > 0) {
                    let per = this.getFlatFee('rope_color', 'special');
                    fees.push({ name: `สีเชือกพิเศษ (${this.selections.specialRopeColors.length} สี)`, amount: this.selections.specialRopeColors.length * per });
                }
                // สีสกรีน: ไม่เลือก=สีขาว(1,000) | เลือก=จำนวนช่อง×1,000
                let perScreen = this.getFlatFee('screen_color', 'per_color') || 1000;
                let screenCount = this.selections.wantScreenColor ? this.selections.screenColorFields.length : 1;
                fees.push({ name: `ค่าสีสกรีน (${screenCount} สี × ฿${perScreen.toLocaleString()})`, amount: screenCount * perScreen });
                if (this.selections.needExpress) fees.push({ name: 'ค่าจัดส่งเร่งด่วน', amount: this.expressDeliveryCost });
                return fees;
            },
            get expressDeliveryCost() {
                let qty = this.selections.quantity;
                if (qty >= 395) {
                    let subtotal = (this.ropeUnitPrice + this.yoyoUnitPrice + this.partsUnitPrice + this.cardHolderUnitPrice) * qty;
                    return Math.round(subtotal * 0.10);
                }
                return this.getFlatFee('express', 'flat') || 200;
            },
            get expressDeliveryLabel() { return this.selections.quantity >= 395 ? '10% ≈ ฿' + this.expressDeliveryCost.toLocaleString() : '฿200'; },
            get totalFlatFee() { return this.addedFees.reduce((sum, f) => sum + f.amount, 0); },
            get grandTotal() { return ((this.ropeUnitPrice + this.yoyoUnitPrice + this.partsUnitPrice + this.cardHolderUnitPrice) * this.selections.quantity) + this.totalFlatFee; },

            // Build product label for quotation
            get productLabel() {
                let p = this.selectedProduct;
                let label = p.name;
                if (this.config.sizes.length > 0) label += ' ' + this.selections.ropeSize;
                if (this.config.showScreen) label += '(' + (this.selections.screenFormat === '2side' ? 'สกรีนสองด้าน' : 'สกรีนด้านเดียว') + ')';
                if (this.config.showStep2 && this.config.step2Mode === 'swatches' && this.selections.ropeColors.length > 0) label += '(' + this.selections.ropeColors.join(',') + ')';
                if (this.config.showStep3 && this.config.step3Mode === 'swatches') {
                    if (this.selections.wantScreenColor) {
                        let cols = this.selections.screenColorFields.filter(f => f.trim());
                        if (cols.length > 0) label += '(' + cols.join(',') + ')';
                    }
                }
                return label;
            },

            // Build itemized line items for price table & custom_data
            get buildLineItems() {
                let lines = [];
                let qty = this.selections.quantity;

                // 1. Main product (rope)
                lines.push({ item: this.productLabel, unit_cost: this.ropeUnitPrice, qty: qty, total: this.ropeUnitPrice * qty });

                // 2. Yoyo
                if (this.isYoyo && this.selections.selectedYoyoId) {
                    let p = this.yoyoPartsData.find(x => x.id === this.selections.selectedYoyoId);
                    if (p) lines.push({ item: 'โยโย่: ' + p.name, unit_cost: this.yoyoUnitPrice, qty: qty, total: this.yoyoUnitPrice * qty });
                } else if (!this.isYoyo && this.selections.optionalYoyoType) {
                    let label = this.selections.optionalYoyoType === 'black' ? 'โยโย่ดำ' : (this.selections.optionalYoyoType === 'bw' ? 'โยโย่ขาว-ดำ' : 'โยโย่สี');
                    lines.push({ item: 'โยโย่: ' + label, unit_cost: this.yoyoUnitPrice, qty: qty, total: this.yoyoUnitPrice * qty });
                }

                // 3. Parts (Other + Special + Free)
                this.selections.selectedOtherParts.forEach(id => {
                    let p = this.partsData.find(x => x.id == id);
                    if (p) {
                        let up = this.getRatePrice('part', `other_${id}`, qty);
                        lines.push({ item: p.name, unit_cost: up, qty: qty, total: up * qty });
                    }
                });
                if (this.selections.wantSpecialParts) {
                    this.selections.selectedSpecialParts.forEach(id => {
                        let p = this.partsData.find(x => x.id == id);
                        if (p) {
                            let up = this.getRatePrice('part', `special_${id}`, qty);
                            if (up === 0) up = parseFloat(p.base_price) || 0;
                            lines.push({ item: p.name, unit_cost: up, qty: qty, total: up * qty });
                        }
                    });
                }
                this.selections.selectedFreeParts.forEach(id => {
                    let p = this.partsData.find(x => x.id == id);
                    if (p) lines.push({ item: p.name + ' (ฟรี)', unit_cost: 0, qty: qty, total: 0 });
                });

                // 4. Card Holder
                if (this.selections.wantCardHolder && this.selections.cardHolder) {
                    let ch = this.cardHoldersData.find(x => x.id == this.selections.cardHolder);
                    if (ch) {
                        let up = parseFloat(ch.base_price) || 0;
                        lines.push({ item: 'ซองใส่บัตร: ' + ch.name, unit_cost: up, qty: qty, total: up * qty });
                    }
                }

                // 5. Each added fee (flat fees)
                this.addedFees.forEach(f => {
                    if (f.amount > 0) {
                        lines.push({ item: f.name, unit_cost: f.amount, qty: 1, total: f.amount });
                    }
                });

                return lines;
            },

            // ── Navigation ──
            init() {
                // Restore selections from edit mode
                @if(isset($editSelections))
                    let saved = @json($editSelections);
                    if (saved) {
                        Object.assign(this.selections, saved);
                        this.selectedProductId = {{ $editProductId ?? $product->id }};
                    }
                @endif
                if (this.config.sizes.length > 0 && !this.selections.ropeSize) this.selections.ropeSize = this.config.sizes.includes('15mm') ? '15mm' : this.config.sizes[0];
                let imgs = this.productImages; this.mainImage = imgs[0] || '/images/no-image.svg';
            },
            validateAll() {
                if (this.config.sizes.length > 0 && !this.selections.ropeSize) {
                    Swal.fire({ icon:'warning', title:'กรุณาเลือกขนาดสาย (Step 1)', confirmButtonColor:'#004998' }); return false;
                }
                if (this.config.showStep2) {
                    if (this.config.step2Mode === 'swatches' && this.selections.ropeColors.length === 0) {
                        Swal.fire({ icon:'warning', title:'กรุณาเลือกสีเชือกอย่างน้อย 1 สี (Step 2)', confirmButtonColor:'#004998' }); return false;
                    }
                    if (this.config.step2Mode === 'text' && !this.selections.jacquardRopeColor.trim()) {
                        Swal.fire({ icon:'warning', title:'กรุณาระบุสีเส้นด้าย (Step 2)', confirmButtonColor:'#004998' }); return false;
                    }
                }
                if (this.config.showStep3) {
                    if (this.selections.wantScreenColor) {
                        let filled = this.selections.screenColorFields.length;
                        if (filled === 0) { this.screenFieldError = true; Swal.fire({ icon:'warning', title:'กรุณาเพิ่มสีอย่างน้อย 1 สี (Step 3)', confirmButtonColor:'#004998' }); return false; }
                    }
                    this.screenFieldError = false;
                    if (this.config.step3Mode === 'text' && !this.selections.jacquardLogoColor.trim()) {
                        Swal.fire({ icon:'warning', title:'กรุณาระบุสีโลโก้ (Step 3)', confirmButtonColor:'#004998' }); return false;
                    }
                }
                if (this.selections.wantCardHolder && !this.selections.cardHolder) {
                    Swal.fire({ icon:'warning', title:'กรุณาเลือกซองใส่บัตร (Step 5)', confirmButtonColor:'#004998' }); return false;
                }
                if (this.isYoyo && !this.selections.selectedYoyoId) {
                    Swal.fire({ icon:'warning', title:'กรุณาเลือกส่วนประกอบพิเศษ (Step 4)', confirmButtonColor:'#004998' }); return false;
                }
                return true;
            },
            onProductChange() {
                let cfg = this.config;
                this.selections.ropeSize = cfg.sizes.includes('15mm') ? '15mm' : (cfg.sizes[0] || '');
                this.selections.screenFormat = '1side'; this.selections.clipColor = 'คลิปดำ';
                this.selections.ropeColors = []; this.selections.wantSpecialRopeColor = false; this.selections.specialRopeColors = [];
                this.selections.jacquardRopeColor = ''; this.selections.jacquardLogoColor = '';
                this.selections.wantScreenColor = false; this.selections.screenColorFields = [];
                this.selections.selectedFreeParts = []; this.selections.selectedOtherParts = []; this.selections.selectedSpecialParts = [];
                this.selections.wantSpecialParts = false; this.selections.wantCardHolder = false; this.selections.cardHolder = '';
                this.selections.yoyoType = 'bw'; this.selections.yoyoColor = 'สีดำ'; this.selections.yoyoSticker = false;
                this.selections.needSample = false; this.selections.needExpress = false;
                let imgs = this.productImages; this.mainImage = imgs[0] || '/images/no-image.svg';
            },
            toggleRopeColor(name) {
                let i = this.selections.ropeColors.indexOf(name);
                if (i >= 0) this.selections.ropeColors.splice(i, 1);
                else if (this.selections.ropeColors.length < 5) this.selections.ropeColors.push(name);
            },
            
            toggleArray(arr, id) {
                let i = arr.indexOf(id);
                if (i >= 0) arr.splice(i, 1); else arr.push(id);
            },
            addSpecialRopeColor() { let c = this.newSpecialRopeColor.trim(); if (c && !this.selections.specialRopeColors.includes(c) && this.selections.specialRopeColors.length < 3) { this.selections.specialRopeColors.push(c); this.newSpecialRopeColor = ''; } },
            addScreenColor() { let c = this.newScreenColor.trim(); if (c && !this.selections.screenColorFields.includes(c) && this.selections.screenColorFields.length < 6) { this.selections.screenColorFields.push(c); this.newScreenColor = ''; } },

            submitToCart() {
                if (!this.validateAll()) return;
                
                // Build options summary for display
                let options = [];
                options.push('ประเภทสาย: ' + this.selectedProduct.name);
                if (this.config.sizes.length > 0) options.push('ขนาด: ' + this.selections.ropeSize);
                if (this.config.showScreen) options.push('การสกรีน: ' + (this.selections.screenFormat === '2side' ? 'สกรีนสองด้าน' : 'สกรีนด้านเดียว'));
                if (this.config.showClip) options.push('สีคลิป: ' + this.selections.clipColor);
                if (this.config.showStep2) {
                    if (this.config.step2Mode === 'text') options.push('สีเส้นด้าย: ' + (this.selections.jacquardRopeColor || '-'));
                    else { if (this.selections.ropeColors.length) options.push('สีเชือก: ' + this.selections.ropeColors.join(', ')); if (this.selections.wantSpecialRopeColor && this.selections.specialRopeColors.length) options.push('สีเชือกพิเศษ: ' + this.selections.specialRopeColors.join(', ')); }
                }
                if (this.config.showStep3) {
                    if (this.config.step3Mode === 'text') options.push('สีโลโก้: ' + (this.selections.jacquardLogoColor || '-'));
                    else {
                        if (this.selections.wantScreenColor) {
                            let colors = this.selections.screenColorFields.filter(f => f.trim());
                            options.push('สีสกรีน: ' + (colors.length > 0 ? colors.join(', ') : 'สีขาว'));
                        } else {
                            options.push('สีสกรีน: สีขาว (พื้นฐาน)');
                        }
                    }
                }
                if (this.isYoyo) options.push('โยโย่: ' + this.selections.yoyoType + (this.selections.yoyoType !== 'black' ? ' ' + this.selections.yoyoColor : '') + (this.selections.yoyoSticker ? ' (ติดสติ๊กเกอร์)' : ''));
                else {
                    this.selections.selectedFreeParts.forEach(id => { let p = this.partsData.find(x => x.id == id); if (p) options.push('Free Part: ' + p.name); });
                    this.selections.selectedOtherParts.forEach(id => { let p = this.partsData.find(x => x.id == id); if (p) options.push('Other Part: ' + p.name); });
                    if (this.selections.wantSpecialParts) this.selections.selectedSpecialParts.forEach(id => { let p = this.partsData.find(x => x.id == id); if (p) options.push('Special Part: ' + p.name); });
                }
                if (this.selections.wantCardHolder && this.selections.cardHolder) { let ch = this.cardHoldersData.find(x => x.id == this.selections.cardHolder); if (ch) options.push('ซองใส่บัตร: ' + ch.name); }
                if (this.selections.needSample) options.push('ต้องการตัวอย่าง');
                if (this.selections.needExpress) options.push('จัดส่งแบบเร่งด่วน');
                options.push('ราคารวม: ฿' + this.grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2}));

                // Build custom_data with detailed line items + selections for restore
                let customData = {
                    product_label: this.productLabel,
                    line_items: this.buildLineItems,
                    subtotal: this.grandTotal,
                    unit_price_rope: this.ropeUnitPrice,
                    selections: JSON.parse(JSON.stringify(this.selections))
                };

                let unitCost = this.ropeUnitPrice + this.yoyoUnitPrice + this.partsUnitPrice + this.cardHolderUnitPrice;

                let payload = {
                    product_id: this.selectedProductId,
                    quantity: this.selections.quantity,
                    options_snapshot: options,
                    custom_data: customData,
                    unit_price: unitCost
                };

                // If editing existing cart item, include cart_item_id
                if (this.editCartItemId) {
                    payload.edit_cart_item_id = this.editCartItemId;
                }

                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(res => {
                    if (res.success) {
                        let msg = this.editCartItemId ? 'อัปเดตรายการในตะกร้าเรียบร้อย' : 'เพิ่มรายการลงตะกร้าเรียบร้อย';
                        Swal.fire({ title: 'สำเร็จ!', text: msg, icon: 'success', showCancelButton: true, confirmButtonColor: '#004998', cancelButtonColor: '#9CA3AF', confirmButtonText: 'ไปยังตะกร้า', cancelButtonText: 'เลือกซื้อต่อ' }).then(r => { if (r.isConfirmed) window.location.href = '{{ route("cart.index") }}'; else window.location.href = '{{ route("products.index") }}'; });
                    } else Swal.fire('ข้อผิดพลาด', res.message || 'ไม่สามารถเพิ่มสินค้าได้', 'error');
                }).catch(() => Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อระบบได้', 'error'));
            },

            requestQuotation() {
                if (!this.validateAll()) return;

                Swal.fire({
                    icon: 'warning',
                    title: 'ยืนยันขอใบเสนอราคา ?',
                    html: '<div style="font-size:14px; color:#555; line-height:1.7;">ใบเสนอราคานี้จัดทำโดยระบบอัตโนมัติเพื่อเป็นการอ้างอิงราคา<br>เบื้องต้นเท่านั้นกรุณาติดต่อฝ่ายขายเพื่อยืนข้อมูลการสั่งซื้อ<br>และราคาอย่างเป็นทางการ</div>',
                    showCancelButton: true,
                    confirmButtonText: 'ดำเนินการต่อ',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#e5e5e5',
                    reverseButtons: true,
                    customClass: {
                        cancelButton: 'swal2-cancel-custom'
                    },
                    didOpen: () => {
                        // Style cancel button text to dark
                        const cancelBtn = Swal.getCancelButton();
                        if (cancelBtn) { cancelBtn.style.color = '#333'; }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this._processQuotation();
                    }
                });
            },

            _processQuotation() {
                // Build same options & payload as submitToCart
                let options = [];
                options.push('ประเภทสาย: ' + this.selectedProduct.name);
                if (this.config.sizes.length > 0) options.push('ขนาด: ' + this.selections.ropeSize);
                if (this.config.showScreen) options.push('การสกรีน: ' + (this.selections.screenFormat === '2side' ? 'สกรีนสองด้าน' : 'สกรีนด้านเดียว'));
                if (this.config.showClip) options.push('สีคลิป: ' + this.selections.clipColor);
                if (this.config.showStep2) {
                    if (this.config.step2Mode === 'text') options.push('สีเส้นด้าย: ' + (this.selections.jacquardRopeColor || '-'));
                    else { if (this.selections.ropeColors.length) options.push('สีเชือก: ' + this.selections.ropeColors.join(', ')); if (this.selections.wantSpecialRopeColor && this.selections.specialRopeColors.length) options.push('สีเชือกพิเศษ: ' + this.selections.specialRopeColors.join(', ')); }
                }
                if (this.config.showStep3) {
                    if (this.config.step3Mode === 'text') options.push('สีโลโก้: ' + (this.selections.jacquardLogoColor || '-'));
                    else {
                        if (this.selections.wantScreenColor) {
                            let colors = this.selections.screenColorFields.filter(f => f.trim());
                            options.push('สีสกรีน: ' + (colors.length > 0 ? colors.join(', ') : 'สีขาว'));
                        } else {
                            options.push('สีสกรีน: สีขาว (พื้นฐาน)');
                        }
                    }
                }
                if (this.isYoyo) options.push('โยโย่: ' + this.selections.yoyoType + (this.selections.yoyoType !== 'black' ? ' ' + this.selections.yoyoColor : '') + (this.selections.yoyoSticker ? ' (ติดสติ๊กเกอร์)' : ''));
                else {
                    this.selections.selectedFreeParts.forEach(id => { let p = this.partsData.find(x => x.id == id); if (p) options.push('Free Part: ' + p.name); });
                    this.selections.selectedOtherParts.forEach(id => { let p = this.partsData.find(x => x.id == id); if (p) options.push('Other Part: ' + p.name); });
                    if (this.selections.wantSpecialParts) this.selections.selectedSpecialParts.forEach(id => { let p = this.partsData.find(x => x.id == id); if (p) options.push('Special Part: ' + p.name); });
                }
                if (this.selections.wantCardHolder && this.selections.cardHolder) { let ch = this.cardHoldersData.find(x => x.id == this.selections.cardHolder); if (ch) options.push('ซองใส่บัตร: ' + ch.name); }
                if (this.selections.needSample) options.push('ต้องการตัวอย่าง');
                if (this.selections.needExpress) options.push('จัดส่งแบบเร่งด่วน');
                options.push('ราคารวม: ฿' + this.grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2}));

                let customData = {
                    product_label: this.productLabel,
                    line_items: this.buildLineItems,
                    subtotal: this.grandTotal,
                    unit_price_rope: this.ropeUnitPrice,
                    selections: JSON.parse(JSON.stringify(this.selections))
                };

                let unitCost = this.ropeUnitPrice + this.yoyoUnitPrice + this.partsUnitPrice + this.cardHolderUnitPrice;

                let payload = {
                    product_id: this.selectedProductId,
                    quantity: this.selections.quantity,
                    options_snapshot: options,
                    custom_data: customData,
                    unit_price: unitCost
                };

                // Show loading
                Swal.fire({ title: 'กำลังดำเนินการ...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

                // Add to cart first, then redirect to quotation page
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(res => {
                    if (res.success) {
                        // Redirect directly to quotation page (skip cart)
                        window.location.href = '{{ route("quotation") }}';
                    } else {
                        Swal.fire('ข้อผิดพลาด', res.message || 'ไม่สามารถดำเนินการได้', 'error');
                    }
                }).catch(() => Swal.fire('ข้อผิดพลาด', 'ไม่สามารถเชื่อมต่อระบบได้', 'error'));
            }
        }));
    });
    </script>
    @endpush
</x-app-layout>
