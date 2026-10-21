<?php

use Livewire\Component;

new class extends Component
{
    public int $yearsActive = 0;

    public function mount(): void
    {
        $this->yearsActive = now()->year - 2012;
    }
};
?>

<section class="bg-areia pt-11 pb-9">
    <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-2 lg:grid-cols-4 gap-y-5 lg:gap-y-0">
        <div class="px-0 lg:px-6">
            <div class="flex items-center gap-3.5">
                <x-phosphor-timer class="w-8 h-8 text-azul-principal shrink-0" />
                <strong class="font-display text-xl font-bold text-azul-marinho">{{ $yearsActive }}+</strong>
            </div>
            <small class="block mt-0.5 ml-[46px] text-xs text-cinza leading-tight">anos de história</small>
        </div>
        <div class="px-6 border-l border-cinza-claro">
            <div class="flex items-center gap-3.5">
                <x-phosphor-users-three class="w-8 h-8 text-azul-principal shrink-0" />
                <strong class="font-display text-xl font-bold text-azul-marinho">1.000+</strong>
            </div>
            <small class="block mt-0.5 ml-[46px] text-xs text-cinza leading-tight">membros</small>
        </div>
        <div class="px-0 lg:px-6 lg:border-l border-cinza-claro">
            <div class="flex items-center gap-3.5">
                <x-phosphor-code class="w-8 h-8 text-azul-principal shrink-0" />
                <strong class="font-display text-xl font-bold text-azul-marinho">Eventos</strong>
            </div>
            <small class="block mt-0.5 ml-[46px] text-xs text-cinza leading-tight">Meetups, workshops e PHPeste</small>
        </div>
        <div class="px-6 border-l border-cinza-claro">
            <div class="flex items-center gap-3.5">
                <x-phosphor-book-open-text class="w-8 h-8 text-azul-principal shrink-0" />
                <strong class="font-display text-xl font-bold text-azul-marinho">Conteúdo</strong>
            </div>
            <small class="block mt-0.5 ml-[46px] text-xs text-cinza leading-tight">Artigos, vídeos e materiais gratuitos.</small>
        </div>
    </div>
</section>
