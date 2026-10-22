<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section id="participar" class="pt-10 pb-[70px] bg-azul-fundo">
    <div class="max-w-[1200px] mx-auto px-6">
        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">Comunidade</p>
        <h2 class="font-display text-[clamp(28px,3.2vw,38px)] font-bold text-preto">Faça parte dessa história.</h2>
        <p class="mt-3 max-w-[460px] text-[13.5px] text-cinza">
            A PHP PB é aberta e inclusiva. Todo mundo é bem-vindo, independente do nível de experiência.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5.5 mt-9">
            <article class="text-center px-3.5 py-2.5">
                <div class="grid place-items-center w-[86px] h-[86px] mx-auto mb-4 rounded-full bg-white text-azul-principal shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <x-phosphor-users-three class="w-10 h-10" />
                </div>
                <h4 class="text-[15px] font-semibold text-preto">Participe dos eventos</h4>
                <p class="mt-1 text-[12.5px] text-cinza">Meetups, workshops e muito mais.</p>
            </article>
            <article class="text-center px-3.5 py-2.5">
                <div class="grid place-items-center w-[86px] h-[86px] mx-auto mb-4 rounded-full bg-white text-amarelo-nordeste shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <x-phosphor-pen-nib class="w-10 h-10" />
                </div>
                <h4 class="text-[15px] font-semibold text-preto">Contribua com conteúdo</h4>
                <p class="mt-1 text-[12.5px] text-cinza">Publique seus artigos no painel de membros.</p>
            </article>
            <article class="text-center px-3.5 py-2.5">
                <div class="grid place-items-center w-[86px] h-[86px] mx-auto mb-4 rounded-full bg-white text-azul-marinho shadow-[0_4px_14px_rgba(8,45,82,.08)]">
                    <x-phosphor-handshake class="w-10 h-10" />
                </div>
                <h4 class="text-[15px] font-semibold text-preto">Conecte-se com pessoas</h4>
                <p class="mt-1 text-[12.5px] text-cinza">Faça parte da nossa comunidade.</p>
            </article>
        </div>

        <div class="mt-9 bg-white rounded-2xl p-6 sm:p-7 flex flex-col sm:flex-row items-center gap-5 shadow-[0_4px_14px_rgba(8,45,82,.06)]">
            <div class="shrink-0 grid place-items-center w-14 h-14 rounded-full bg-azul-fundo text-azul-principal">
                <x-phosphor-squares-four class="w-7 h-7" />
            </div>
            <div class="flex-1 text-center sm:text-left">
                <h4 class="text-[15px] font-semibold text-preto">Temos um painel de membros</h4>
                <p class="mt-1 text-[12.5px] text-cinza">
                    Crie sua conta e publique seus próprios artigos direto pelo site. Mais funcionalidades exclusivas pra membros estão a caminho.
                </p>
            </div>
            <a href="{{ route('filament.membro.auth.register') }}"
               class="shrink-0 w-full sm:w-auto justify-center inline-flex items-center gap-2 px-5 py-2.5 rounded-full border-[1.5px] border-azul-principal text-azul-principal font-semibold text-[13px] hover:bg-azul-principal hover:text-white transition-all">
                Criar minha conta
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>

        <div class="text-center mt-7">
            <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full bg-azul-principal hover:bg-[#1779bb] text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)]">
                Quero participar
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>
    </div>
</section>
