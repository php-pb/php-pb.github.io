<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section class="relative -mt-px pt-[90px] pb-[60px] overflow-hidden text-white"
         style="background: linear-gradient(180deg, #3aa7ec 0%, #1e8edb 100%);">
    <svg class="absolute left-0 -top-px w-full h-[60px]" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 80 L0 30 C200 -10 380 60 620 30 C860 0 1060 60 1260 30 C1340 18 1400 24 1440 34 L1440 80Z" fill="#EBF4FC"/>
    </svg>

    <div class="relative max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] items-end gap-7.5">
        <div>
            <h2 class="font-display font-bold text-[clamp(24px,2.8vw,34px)] text-white mb-6">
                Vamos construir o futuro do PHP<br>na Paraíba juntos?
            </h2>
            <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full bg-azul-principal border-[1.5px] border-white/50 hover:bg-[#1779bb] text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5">
                Seja da comunidade
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>

        <div class="hidden lg:flex justify-end" aria-hidden="true">
            <img src="{{ asset('images/hero/farol-cena.png') }}" alt="" class="w-full max-w-[420px]">
        </div>
    </div>
</section>
