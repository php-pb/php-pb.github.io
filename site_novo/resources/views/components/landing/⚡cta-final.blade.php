<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section class="relative -mt-px pt-10 pb-16 lg:pt-12 lg:pb-20 overflow-hidden text-white"
         style="background: linear-gradient(180deg, #3aa7ec 0%, #1e8edb 100%);">
    <svg class="absolute left-0 -top-px w-full h-10 lg:h-14" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 70 C180 10 300 110 520 70 C740 30 880 110 1100 70 C1260 40 1360 60 1440 80 L1440 0 L0 0Z" fill="#F9F6EE"/>
        <path d="M0 80 C200 40 340 120 560 90 C780 60 920 120 1140 90 C1280 70 1380 85 1440 100 L1440 0 L0 0Z" fill="#EBF4FC"/>
    </svg>

    <div class="relative max-w-[1200px] mx-auto px-6 pt-10 lg:pt-14 grid grid-cols-1 lg:grid-cols-2 items-center gap-10">
        <div>
            <h2 class="font-display font-bold text-[clamp(26px,3vw,36px)] leading-tight text-white mb-7">
                Vamos construir o futuro do PHP na Paraíba juntos?
            </h2>
            <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full border-[1.5px] border-white/60 hover:bg-white/10 text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5">
                Seja da comunidade
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>

        <div class="hidden lg:flex justify-center" aria-hidden="true">
            <img src="{{ asset('images/hero/farol-cena.png') }}" alt="" class="w-full max-w-[340px]">
        </div>
    </div>
</section>
