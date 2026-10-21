<?php

use App\Models\Event;
use Livewire\Component;

new class extends Component {
    public $events = [];

    public function mount(): void
    {
        $this->events = Event::published()->upcoming()->orderBy('starts_at')->take(8)->get();

        if ($this->events->isEmpty()) {
            $this->events = Event::published()->past()->orderBy('starts_at', 'desc')->take(8)->get();
        }
    }
};
?>

<section id="eventos" class="relative mt-[60px] pt-[72px] pb-[70px] bg-azul-marinho text-white rounded-t-[60px]">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex justify-between items-end gap-5 flex-wrap mb-7">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-claro mb-3.5">Eventos</p>
                <h2 class="font-display text-[clamp(24px,2.6vw,32px)] font-bold text-white">
                    Encontros que<br>fortalecem a comunidade.
                </h2>
            </div>
            <a href="{{ route('events.index') }}"
               class="w-full sm:w-auto justify-center inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full bg-azul-principal hover:bg-[#1779bb] text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)]">
                Ver todos os eventos
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>

        @if (count($events) === 0)
            <p class="text-center text-white/70">Nenhum evento publicado no momento. Volte em breve!</p>
        @elseif (count($events) <= 4)
            {{-- Poucos eventos: grade simples, sem carrossel (evita cards soltos e setas sem função) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($events as $i => $event)
                    <x-landing.event-card :event="$event" :index="$i" />
                @endforeach
            </div>
        @else
            <div x-data="{
                step() {
                    const card = this.$refs.track.querySelector(':scope > *');
                    return card ? card.getBoundingClientRect().width + 16 : 300;
                },
                prev() { this.$refs.track.scrollBy({ left: -this.step(), behavior: 'smooth' }); },
                next() { this.$refs.track.scrollBy({ left: this.step(), behavior: 'smooth' }); },
            }" class="relative">
                <button @click="prev" type="button" aria-label="Eventos anteriores"
                        class="hidden sm:grid place-items-center absolute top-[40%] -left-[18px] z-[5] w-[38px] h-[38px] rounded-full bg-white text-azul-marinho shadow-[0_6px_16px_rgba(0,0,0,.25)] hover:scale-[1.08] transition-transform">
                    <x-phosphor-caret-left class="w-4 h-4" />
                </button>

                <div x-ref="track" class="no-scrollbar grid grid-flow-col [grid-auto-columns:82%] sm:[grid-auto-columns:calc((100%-16px)/2)] lg:[grid-auto-columns:calc((100%-48px)/4)] gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-1">
                    @foreach ($events as $i => $event)
                        <x-landing.event-card :event="$event" :index="$i" />
                    @endforeach
                </div>

                <button @click="next" type="button" aria-label="Próximos eventos"
                        class="hidden sm:grid place-items-center absolute top-[40%] -right-[18px] z-[5] w-[38px] h-[38px] rounded-full bg-white text-azul-marinho shadow-[0_6px_16px_rgba(0,0,0,.25)] hover:scale-[1.08] transition-transform">
                    <x-phosphor-caret-right class="w-4 h-4" />
                </button>
            </div>
        @endif
    </div>
</section>
