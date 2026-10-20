<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section id="comunidade" class="relative text-white py-[70px] lg:py-[110px] overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero/evento.jpg') }}')"></div>
    <div class="absolute inset-0" style="background: linear-gradient(90deg, rgba(6,31,58,.92) 0%, rgba(6,31,58,.72) 55%, rgba(6,31,58,.45) 100%);"></div>

    <div class="relative z-[2] max-w-[1200px] mx-auto px-6">
        <h2 class="font-display font-bold text-[clamp(32px,4.2vw,52px)] tracking-[-0.02em] text-white">
            Uma comunidade<br>feita por pessoas,<br><span class="text-azul-claro">para pessoas.</span>
        </h2>
        <p class="my-5 max-w-[420px] text-sm text-[#dbe7f3]">
            Desenvolvedores, estudantes, entusiastas e empresas que acreditam no poder do PHP e da comunidade.
        </p>
        <a href="/#participar"
           class="inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full bg-azul-principal hover:bg-[#1779bb] text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)]">
            Seja parte
            <x-phosphor-arrow-right class="w-4 h-4" />
        </a>
    </div>
</section>
