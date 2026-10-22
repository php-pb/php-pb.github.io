<?php

use Livewire\Component;

new class extends Component
{
    public bool $mobileMenuOpen = false;

    public function toggleMobileMenu(): void
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }
};
?>

<header
    data-site-header
    class="sticky top-0 z-50 bg-areia/92 backdrop-blur-md border-b border-azul-marinho/[0.06] transition-shadow"
>
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex items-center justify-between h-[72px]">
            <a href="/" class="inline-flex items-center gap-2 rounded-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-principal">
                <img src="{{ asset('images/hero/mascote.png') }}" alt="" class="h-[46px] w-auto">
                <span class="flex flex-col gap-0 font-display">
                    <b class="text-2xl leading-none font-extrabold text-azul-marinho tracking-[-0.5px]">PHP</b>
                    <b class="text-2xl leading-none font-extrabold text-azul-marinho tracking-[-0.5px]">PB</b>
                </span>
            </a>

            <nav class="hidden md:flex items-center gap-7" aria-label="Navegação principal">
                <a href="/#sobre" class="group relative text-[12.5px] font-medium text-azul-marinho">
                    Sobre
                    <span class="absolute left-0 -bottom-1.5 h-0.5 w-0 bg-azul-principal transition-all duration-200 group-hover:w-full"></span>
                </a>
                <a href="{{ route('events.index') }}" class="group relative text-[12.5px] font-medium text-azul-marinho">
                    Eventos
                    <span class="absolute left-0 -bottom-1.5 h-0.5 bg-azul-principal transition-all duration-200 {{ request()->routeIs('events.index') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="{{ route('blog.index') }}" class="group relative text-[12.5px] font-medium text-azul-marinho">
                    Conteúdos
                    <span class="absolute left-0 -bottom-1.5 h-0.5 bg-azul-principal transition-all duration-200 {{ request()->routeIs('blog.*') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                </a>
                <a href="/#comunidade" class="group relative text-[12.5px] font-medium text-azul-marinho">
                    Comunidade
                    <span class="absolute left-0 -bottom-1.5 h-0.5 w-0 bg-azul-principal transition-all duration-200 group-hover:w-full"></span>
                </a>
                <a href="/#participar" class="group relative text-[12.5px] font-medium text-azul-marinho">
                    Como participar
                    <span class="absolute left-0 -bottom-1.5 h-0.5 w-0 bg-azul-principal transition-all duration-200 group-hover:w-full"></span>
                </a>
                <a href="{{ auth()->check() ? route('filament.membro.pages.dashboard') : route('filament.membro.auth.login') }}"
                   class="inline-flex items-center gap-1.5 text-[12.5px] font-medium text-azul-marinho hover:text-azul-principal transition-colors">
                    <x-phosphor-user-circle class="w-[18px] h-[18px]" />
                    @auth
                        Meu painel
                    @else
                        Entrar
                    @endauth
                </a>

                <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-[18px] py-[11px] bg-azul-principal hover:bg-[#1779bb] active:scale-[0.98] text-white text-[13px] font-semibold rounded-full transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-claro">
                    Seja parte
                    <x-phosphor-arrow-right class="w-4 h-4" />
                </a>
            </nav>

            <button
                wire:click="toggleMobileMenu"
                type="button"
                aria-label="{{ $mobileMenuOpen ? 'Fechar menu' : 'Abrir menu' }}"
                aria-expanded="{{ $mobileMenuOpen ? 'true' : 'false' }}"
                class="md:hidden w-11 h-11 -mr-2 flex flex-col items-center justify-center gap-[5px] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-principal rounded-lg"
            >
                <span class="block w-[22px] h-0.5 bg-azul-marinho transition-transform duration-200" :class="$wire.mobileMenuOpen && 'translate-y-[7px] rotate-45'"></span>
                <span class="block w-[22px] h-0.5 bg-azul-marinho transition-opacity duration-200" :class="$wire.mobileMenuOpen && 'opacity-0'"></span>
                <span class="block w-[22px] h-0.5 bg-azul-marinho transition-transform duration-200" :class="$wire.mobileMenuOpen && '-translate-y-[7px] -rotate-45'"></span>
            </button>
        </div>
    </div>

    <nav x-show="$wire.mobileMenuOpen" x-transition x-cloak class="md:hidden bg-areia border-b border-azul-marinho/10" aria-label="Navegação mobile">
        <div class="px-6 py-2 pb-5">
            <a href="/#sobre" class="block py-3.5 border-b border-azul-marinho/[0.07] text-[15px] font-medium text-azul-marinho">Sobre</a>
            <a href="{{ route('events.index') }}" class="block py-3.5 border-b border-azul-marinho/[0.07] text-[15px] font-medium {{ request()->routeIs('events.index') ? 'text-azul-principal' : 'text-azul-marinho' }}">Eventos</a>
            <a href="{{ route('blog.index') }}" class="block py-3.5 border-b border-azul-marinho/[0.07] text-[15px] font-medium {{ request()->routeIs('blog.*') ? 'text-azul-principal' : 'text-azul-marinho' }}">Conteúdos</a>
            <a href="/#comunidade" class="block py-3.5 border-b border-azul-marinho/[0.07] text-[15px] font-medium text-azul-marinho">Comunidade</a>
            <a href="/#participar" class="block py-3.5 border-b border-azul-marinho/[0.07] text-[15px] font-medium text-azul-marinho">Como participar</a>
            <a href="{{ auth()->check() ? route('filament.membro.pages.dashboard') : route('filament.membro.auth.login') }}"
               class="flex items-center gap-2 py-3.5 text-[15px] font-medium text-azul-marinho">
                <x-phosphor-user-circle class="w-5 h-5" />
                @auth
                    Meu painel
                @else
                    Entrar / Criar conta
                @endauth
            </a>
            <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t" target="_blank" rel="noopener"
               class="flex items-center justify-center gap-2 w-full mt-3.5 px-[18px] py-3 bg-azul-principal text-white text-sm font-semibold rounded-full">
                Seja parte
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>
    </nav>
</header>
