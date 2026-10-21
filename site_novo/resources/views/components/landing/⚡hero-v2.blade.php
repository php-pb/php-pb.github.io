<?php

use Livewire\Component;

new class extends Component {
    //
};
?>

<section id="hero" class="relative pt-9 lg:pt-14 overflow-hidden bg-areia">
    <div class="relative z-[2] max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-[0.85fr_1.15fr] gap-6 items-center">
        <!-- Texto -->
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">
                Comunidade PHP da Paraíba
            </p>

            <h1 class="font-display font-extrabold text-[clamp(46px,13vw,64px)] lg:text-[clamp(52px,6.6vw,88px)] leading-[0.98] tracking-[-0.03em] text-preto">
                Gente,<br>código e<br><span class="text-azul-principal">Nordeste.</span>
            </h1>

            <p class="mt-7 max-w-[470px] text-[14.5px] text-[#334155]">
                A PHP PB é a comunidade de desenvolvedores PHP da Paraíba. Conectamos pessoas, compartilhamos
                conhecimento e fortalecemos o ecossistema PHP no nosso estado.
            </p>

            <div class="mt-7.5 flex flex-wrap gap-3.5">
                <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener"
                   class="w-full sm:w-auto justify-center inline-flex items-center gap-2.5 px-5.5 py-3.5 rounded-full bg-azul-marinho hover:bg-[#0b3b6c] text-white font-semibold text-sm transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-claro">
                    Conheça a comunidade
                    <x-phosphor-arrow-right class="w-4 h-4" />
                </a>
                <a href="{{ route('events.index') }}"
                   class="w-full sm:w-auto justify-center inline-flex items-center gap-2.5 px-5.5 py-3.5 rounded-full border-[1.5px] border-azul-principal text-azul-principal font-semibold text-sm transition-all hover:bg-azul-fundo focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-principal">
                    <x-phosphor-calendar-blank class="w-4 h-4" />
                    Próximos eventos
                </a>
            </div>
        </div>

        <!-- Ilustração -->
        <div class="relative w-full max-w-[560px] mx-auto mt-2 lg:max-w-none lg:mx-0 lg:mt-0 aspect-[1/0.98]" aria-hidden="true">
            <span class="absolute right-0 lg:right-[2%] top-[-2%] lg:top-[-4%] z-[4] font-script text-azul-principal text-base lg:text-[clamp(17px,2vw,26px)] leading-[1.1] -rotate-[8deg] text-left">
                Mais comunidade,<br>novos<br>horizontes.
            </span>

            <img src="{{ asset('images/hero/nuvem.png') }}" alt="" class="absolute z-0 w-[16%] left-0 top-[24%] opacity-50">
            <img src="{{ asset('images/hero/nuvem.png') }}" alt="" class="absolute z-0 w-[22%] right-[2%] top-[4%] opacity-50">
            <img src="{{ asset('images/hero/nuvem.png') }}" alt="" class="absolute z-0 w-[18%] right-0 top-[46%] opacity-40">

            <img src="{{ asset('images/hero/sol.png') }}" alt="" class="absolute z-0 w-[50%] left-[30%] top-[2%]">

            <svg viewBox="0 0 200 80" fill="#082D52" class="absolute z-0 w-[24%] left-[2%] top-[8%]">
                <path d="M10 38 q14 -20 28 -4 q14 -18 30 2 q-16 -6 -29 8 q-14 -12 -29 -6z"/>
                <path d="M96 66 q10 -14 20 -3 q10 -12 22 2 q-12 -4 -21 6 q-9 -8 -21 -5z"/>
            </svg>

            <img src="{{ asset('images/hero/farol.png') }}" alt="Farol" class="absolute z-0 w-[96%] left-[4%] top-[6%]">

            <img src="{{ asset('images/hero/palmeira.png') }}" alt="" class="absolute z-0 w-[26%] right-0 top-[54%]">
            <img src="{{ asset('images/hero/palmeira.png') }}" alt="" class="absolute z-0 w-[17%] left-[60%] top-[66%]">

            <img src="{{ asset('images/hero/mascote.png') }}" alt="Mascote da PHP PB" class="absolute z-[3] w-[46%] left-0 top-[56%] drop-shadow-[0_12px_14px_rgba(8,45,82,.18)]">
        </div>
    </div>

    <!-- Onda -->
    <svg class="absolute left-0 bottom-[-1px] z-[1] w-full h-[14%] min-h-[70px] pointer-events-none" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0 70 C180 10 300 110 520 70 C740 30 880 110 1100 70 C1260 40 1360 60 1440 80 L1440 120 L0 120Z" fill="#1E8EDB" opacity=".9"/>
        <path d="M0 90 C200 40 340 120 560 90 C780 60 920 120 1140 90 C1280 70 1380 85 1440 100 L1440 120 L0 120Z" fill="#8DD0F3"/>
    </svg>
</section>
