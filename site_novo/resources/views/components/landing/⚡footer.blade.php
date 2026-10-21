<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<footer class="bg-white pt-[46px]">
    <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[1.3fr_1fr_1fr_1fr] gap-7.5">
        <div>
            <a href="/" class="inline-flex items-center gap-2 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-principal">
                <img src="{{ asset('images/hero/mascote.png') }}" alt="" class="h-[46px] w-auto">
                <span class="flex flex-col gap-0 font-display">
                    <b class="text-2xl leading-none font-extrabold text-azul-marinho tracking-[-0.5px]">PHP</b>
                    <b class="text-2xl leading-none font-extrabold text-azul-marinho tracking-[-0.5px]">PB</b>
                </span>
            </a>
            <p class="mt-3 font-display font-semibold text-[13px] leading-[1.3] text-azul-marinho">
                Gente, código<br>e Nordeste.
            </p>
        </div>

        <div>
            <h5 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-cinza mb-3.5">Navegação</h5>
            <a href="/#sobre" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Sobre</a>
            <a href="{{ route('events.index') }}" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Eventos</a>
            <a href="{{ route('blog.index') }}" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Conteúdos</a>
            <a href="/#comunidade" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Comunidade</a>
            <a href="/#participar" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Como participar</a>
        </div>

        <div>
            <h5 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-cinza mb-3.5">Comunidade</h5>
            <a href="https://github.com/php-pb" target="_blank" rel="noopener" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Código de Conduta</a>
            <a href="/#participar" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Seja um apoiador</a>
            <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener" class="block text-[12.5px] text-azul-marinho hover:text-azul-principal mb-2">Fale conosco</a>
        </div>

        <div>
            <h5 class="text-[11px] font-semibold uppercase tracking-[0.12em] text-cinza mb-3.5">Social</h5>
            <div class="flex gap-3.5">
                <a href="https://github.com/php-pb" target="_blank" rel="noopener" aria-label="GitHub"
                   class="text-azul-marinho hover:text-azul-principal transition-colors">
                    <x-phosphor-github-logo class="w-6 h-6" />
                </a>
                <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener" aria-label="WhatsApp"
                   class="text-azul-marinho hover:text-azul-principal transition-colors">
                    <x-phosphor-whatsapp-logo class="w-6 h-6" />
                </a>
                <a href="https://twitter.com/phppb" target="_blank" rel="noopener" aria-label="Twitter/X"
                   class="text-azul-marinho hover:text-azul-principal transition-colors">
                    <x-phosphor-x-logo class="w-6 h-6" />
                </a>
                <a href="https://www.facebook.com/groups/php.pb" target="_blank" rel="noopener" aria-label="Facebook"
                   class="text-azul-marinho hover:text-azul-principal transition-colors">
                    <x-phosphor-facebook-logo class="w-6 h-6" />
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 flex flex-wrap justify-between gap-2.5 mt-9 pt-[18px] pb-[22px] border-t border-[#e5ebf2] text-[11px] text-cinza">
        <span>&copy; {{ date('Y') }} PHP PB. Gente, código e comunidade no mesmo lado.</span>
        <span class="inline-flex items-center gap-1">Feito com <x-phosphor-heart-fill class="w-3.5 h-3.5 text-vermelho-terra" /> na Paraíba</span>
    </div>
</footer>
