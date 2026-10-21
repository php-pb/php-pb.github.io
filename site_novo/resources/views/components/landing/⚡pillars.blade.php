<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section class="bg-areia pt-5 pb-20">
    <div class="max-w-[1200px] mx-auto px-6">
        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">Nossos pilares</p>
        <h2 class="font-display text-[30px] font-bold text-preto mb-6.5">O que nos move.</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <article class="p-[22px_22px_26px] min-h-[150px] rounded-2xl bg-azul-marinho text-white transition-all hover:-translate-y-1.5 hover:shadow-[0_10px_30px_rgba(8,45,82,.1)]">
                <x-phosphor-users-three class="w-8 h-8 text-white mb-4.5" />
                <h3 class="text-base font-bold text-white mb-1">Comunidade</h3>
                <p class="text-[12.5px] leading-[1.4] text-white/80">Pessoas que constroem juntas.</p>
            </article>
            <article class="p-[22px_22px_26px] min-h-[150px] rounded-2xl bg-[#d5ecfb] transition-all hover:-translate-y-1.5 hover:shadow-[0_10px_30px_rgba(8,45,82,.1)]">
                <x-phosphor-lightbulb class="w-8 h-8 text-azul-principal mb-4.5" />
                <h3 class="text-base font-bold text-preto mb-1">Compartilhamento</h3>
                <p class="text-[12.5px] leading-[1.4] text-preto/70">Conhecimento acessível para todos.</p>
            </article>
            <article class="p-[22px_22px_26px] min-h-[150px] rounded-2xl bg-[#fbefd0] transition-all hover:-translate-y-1.5 hover:shadow-[0_10px_30px_rgba(8,45,82,.1)]">
                <x-phosphor-sun class="w-8 h-8 text-amarelo-nordeste mb-4.5" />
                <h3 class="text-base font-bold text-preto mb-1">Cultura</h3>
                <p class="text-[12.5px] leading-[1.4] text-preto/70">Nosso estado, nossa identidade.</p>
            </article>
            <article class="p-[22px_22px_26px] min-h-[150px] rounded-2xl bg-azul-fundo transition-all hover:-translate-y-1.5 hover:shadow-[0_10px_30px_rgba(8,45,82,.1)]">
                <x-phosphor-chart-bar class="w-8 h-8 text-azul-principal mb-4.5" />
                <h3 class="text-base font-bold text-preto mb-1">Crescimento</h3>
                <p class="text-[12.5px] leading-[1.4] text-preto/70">Mais oportunidades para o ecossistema PHP.</p>
            </article>
        </div>
    </div>
</section>
