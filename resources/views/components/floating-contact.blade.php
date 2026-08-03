<div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50 text-[12px] flex flex-col items-end">
    <!-- Stacked Buttons -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="mb-3 space-y-2.5 flex flex-col items-end"
         style="display: none;">
        
        <!-- Button 1: แชททาง Line -->
        <a href="https://line.me/ti/p/@842kcbjl" target="_blank" class="flex items-center space-x-2 bg-[#4CD964] hover:bg-[#3ec455] text-white px-4 py-2.5 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-x-1 border border-white/20">
            <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24">
                <path d="M19.365 9.863c.349.0.63.285.63.631.0.345-.281.63-.63.63H17.61v1.125h1.755c.349.0.63.283.63.63.0.344-.281.629-.63.629h-2.386c-.345.0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346.0.627.285.627.63.0.349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211.0-.416-.105-.536-.289l-2.007-3.003v2.661c0 .345-.282.63-.63.63-.346.0-.627-.285-.627-.63V8.108c0-.27.174-.51.432-.596.264-.085.549.011.735.29l2.007 3.003V8.147c0-.345.282-.63.63-.63.346.0.627.285.627.63v4.732zm-6.174.0h-.006c-.347.0-.629-.283-.629-.629V8.108c0-.345.282-.63.63-.63.346.0.627.285.627.63v4.732c0 .346-.281.629-.622.629zm-2.025.0H5.21c-.345.0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346.0.627.285.627.63v4.102h1.466c.348.0.629.283.629.63.0.344-.281.629-.629.629zM12 2C6.477 2 2 5.922 2 10.761c0 4.329 3.58 7.972 8.423 8.653.328.071.774.218.887.5.102.254.066.652.032.91-.053.407-.247 1.589-.272 1.93-.038.514.237.508.497.337.261-.17 3.864-2.3 5.275-3.153C19.782 18.239 22 14.774 22 10.761 22 5.922 17.523 2 12 2z"/>
            </svg>
            <span class="font-bold text-[12px] underline underline-offset-2">แชททาง Line</span>
        </a>

        <!-- Button 2: ขอใบเสนอราคา (#DDDDDD bg) -->
        <a href="/quotation" class="flex items-center space-x-2 bg-[#DDDDDD] hover:bg-[#D4D4D4] text-[#000000] px-4 py-2.5 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-x-1 border border-[#E4E4E4]">
            <svg class="w-5 h-5 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="font-bold text-[12px]">ขอใบเสนอราคา</span>
        </a>

        <!-- Button 3: ติดต่อเรา (#FFFFFF bg, #000000 text) -->
        <a href="/contact" class="flex items-center space-x-2 bg-[#FFFFFF] hover:bg-gray-100 text-[#000000] px-4 py-2.5 rounded-2xl shadow-md hover:shadow-lg transition-all transform hover:-translate-x-1 border border-[#E4E4E4]">
            <svg class="w-5 h-5 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span class="font-bold text-[12px]">ติดต่อเรา</span>
        </a>
    </div>

    <!-- Trigger Button (Bg: #FFFFFF, Text: #000000, Size: 12px) -->
    <button @click="open = !open" 
            class="w-14 h-14 rounded-full shadow-2xl flex flex-col items-center justify-center transition-all transform active:scale-90 focus:outline-none border-2 border-[#E4E4E4]"
            :class="open ? 'bg-[#122244] text-white' : 'bg-[#FFFFFF] text-[#000000] hover:bg-gray-50'"
            title="สอบถาม / ติดต่อเรา">
        <template x-if="!open">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-6 h-6 text-[#000000]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6M3 18a2 2 0 002 2h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4zm18 0a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4a2 2 0 012-2h2a2 2 0 012 2v4z"/>
                </svg>
                <span class="text-[11px] font-semibold text-[#000000] -mt-0.5">สอบถาม</span>
            </div>
        </template>

        <template x-if="open">
            <svg class="w-7 h-7 stroke-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </template>
    </button>
</div>
