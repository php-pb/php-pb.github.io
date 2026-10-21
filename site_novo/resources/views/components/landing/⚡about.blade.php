<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section id="sobre" class="relative py-14 lg:py-[70px] bg-areia">
    <div class="relative max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] items-center gap-10 lg:gap-[60px]">
        <div class="relative">
            <div class="relative aspect-[1.35/1] overflow-hidden shadow-[0_10px_30px_rgba(8,45,82,.1)] rounded-[58%_42%_46%_54%/64%_52%_48%_36%]">
                <img src="{{ asset('images/hero/joao-pessoa.jpg') }}" alt="Orla de João Pessoa, Paraíba" class="w-full h-full object-cover">
            </div>
            <img src="{{ asset('images/hero/ondas.png') }}" alt="" class="absolute w-[120px] -right-8 -bottom-1" aria-hidden="true">
        </div>

        <div class="relative">
            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">Nossa essência</p>
            <h2 class="font-display font-bold text-[clamp(30px,3.4vw,42px)] text-preto">
                Tecnologia que<br><span class="text-azul-principal">nasce do nosso lugar.</span>
            </h2>
            <p class="my-4.5 max-w-[430px] text-[14.5px] text-[#334155]">
                Acreditamos no poder da comunidade para transformar realidades. Da beira-mar ao sertão, unimos
                pessoas que fazem o PHP acontecer na Paraíba.
            </p>
            <a href="/#comunidade" class="inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full bg-azul-principal hover:bg-[#1779bb] text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)]">
                Nossa história
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>

        <img src="{{ asset('images/hero/nuvem.png') }}" alt="" class="hidden lg:block absolute w-[120px] -right-2.5 top-0 opacity-55" aria-hidden="true">
    </div>
</section>
