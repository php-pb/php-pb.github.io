<div class="max-w-[1200px] mx-auto px-6 py-12 bg-areia">
    <div class="flex flex-wrap gap-2 mb-8">
        <button wire:click="$set('filter', 'all')" type="button"
                @class([
                    'px-4 py-2 rounded-full text-sm font-semibold transition-all',
                    'bg-azul-principal text-white' => $filter === 'all',
                    'bg-white text-cinza border border-cinza-claro hover:border-azul-principal' => $filter !== 'all',
                ])>
            Todos
        </button>
        <button wire:click="$set('filter', 'upcoming')" type="button"
                @class([
                    'px-4 py-2 rounded-full text-sm font-semibold transition-all',
                    'bg-azul-principal text-white' => $filter === 'upcoming',
                    'bg-white text-cinza border border-cinza-claro hover:border-azul-principal' => $filter !== 'upcoming',
                ])>
            Próximos
        </button>
        <button wire:click="$set('filter', 'past')" type="button"
                @class([
                    'px-4 py-2 rounded-full text-sm font-semibold transition-all',
                    'bg-azul-principal text-white' => $filter === 'past',
                    'bg-white text-cinza border border-cinza-claro hover:border-azul-principal' => $filter !== 'past',
                ])>
            Passados
        </button>
    </div>

    @if (count($events) > 0)
        <div class="space-y-6">
            @foreach ($events as $event)
                @php $isPast = $event->starts_at->isPast(); @endphp
                <article wire:key="event-{{ $event->id }}" @class([
                    'group relative bg-white rounded-2xl shadow-[0_4px_16px_rgba(8,45,82,.07)] hover:shadow-[0_10px_30px_rgba(8,45,82,.1)] hover:-translate-y-1 transition-all overflow-hidden',
                    'ring-2 ring-amarelo-nordeste' => $event->is_featured && ! $isPast,
                    'opacity-70' => $isPast,
                ])>
                    @if ($event->is_featured && ! $isPast)
                        <div class="absolute top-0 right-0 bg-amarelo-nordeste text-preto text-xs font-bold px-4 py-1 rounded-bl-xl">
                            DESTAQUE
                        </div>
                    @elseif ($isPast)
                        <div class="absolute top-0 right-0 bg-cinza text-white text-xs font-bold px-4 py-1 rounded-bl-xl">
                            ENCERRADO
                        </div>
                    @endif

                    <div class="grid lg:grid-cols-12 gap-6 p-6 lg:p-8">
                        <div class="lg:col-span-2">
                            <div class="inline-flex lg:flex lg:flex-col items-center lg:items-stretch bg-azul-fundo rounded-xl p-4 text-center gap-1">
                                <div class="font-display text-4xl lg:text-5xl font-bold text-azul-marinho">{{ $event->starts_at->format('d') }}</div>
                                <div class="text-azul-principal font-semibold text-sm uppercase">{{ $event->starts_at->translatedFormat('M') }}</div>
                                <div class="text-cinza text-xs">{{ $event->starts_at->format('Y') }}</div>
                            </div>
                        </div>

                        <div class="lg:col-span-7">
                            <h2 class="font-display text-2xl font-bold text-preto mb-3">{{ $event->title }}</h2>
                            @if ($event->description)
                                <p class="text-cinza mb-4">{{ $event->description }}</p>
                            @endif

                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center text-cinza">
                                    <x-phosphor-clock class="w-5 h-5 mr-2 text-azul-principal" />
                                    {{ $event->starts_at->format('H:i') }}
                                </div>

                                <div class="flex items-center text-cinza">
                                    <x-phosphor-map-pin class="w-5 h-5 mr-2 text-azul-principal" />
                                    {{ $event->location }}
                                </div>

                                <span class="px-3 py-1 bg-azul-fundo text-azul-principal rounded-full text-xs font-semibold">
                                    {{ $event->type->getLabel() }}
                                </span>
                            </div>
                        </div>

                        <div class="lg:col-span-3 flex lg:flex-col items-center lg:items-end justify-between lg:justify-center gap-4">
                            @if ($event->attendees_count)
                                <div class="text-center">
                                    <div class="font-display text-3xl font-bold text-azul-marinho">{{ $event->attendees_count }}</div>
                                    <div class="text-cinza text-xs">confirmados</div>
                                </div>
                            @endif

                            @if ($isPast)
                                <span class="text-cinza text-sm font-medium">Evento encerrado</span>
                            @elseif ($event->external_url)
                                <a href="{{ $event->external_url }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-azul-principal hover:bg-azul-marinho active:scale-[0.98] text-white font-semibold rounded-full transition-all text-center whitespace-nowrap focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-azul-claro">
                                    Confirmar Presença
                                    <x-phosphor-arrow-right class="w-4 h-4" />
                                </a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="text-center py-24 text-cinza">
            <x-phosphor-calendar-blank class="w-12 h-12 mx-auto mb-4 opacity-50" />
            <p class="text-lg font-medium">
                @if ($filter === 'upcoming')
                    Nenhum evento futuro agendado no momento
                @elseif ($filter === 'past')
                    Nenhum evento passado registrado ainda
                @else
                    Nenhum evento publicado no momento
                @endif
            </p>
        </div>
    @endif
</div>
