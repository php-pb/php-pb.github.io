<x-layouts.app
    title="Eventos - PHP-PB"
    description="Participe dos meetups, workshops e conferências da comunidade PHP da Paraíba. Confira a agenda de eventos passados e futuros."
>
    @if ($upcomingEvents->count() > 0)
        <x-slot:head>
            <script type="application/ld+json">
                {!! json_encode(
                    $upcomingEvents->map(fn ($event) => [
                        '@'.'context' => 'https://schema.org',
                        '@type' => 'Event',
                        'name' => $event->title,
                        'description' => $event->description,
                        'startDate' => $event->starts_at->toIso8601String(),
                        'eventAttendanceMode' => $event->type->value === 'online'
                            ? 'https://schema.org/OnlineEventAttendanceMode'
                            : 'https://schema.org/OfflineEventAttendanceMode',
                        'eventStatus' => 'https://schema.org/EventScheduled',
                        'location' => $event->type->value === 'online' ? [
                            '@type' => 'VirtualLocation',
                            'url' => $event->external_url ?? route('events.index'),
                        ] : [
                            '@type' => 'Place',
                            'name' => $event->location,
                            'address' => $event->location,
                        ],
                        'image' => $event->getBanner(),
                        'url' => $event->external_url ?? route('events.index'),
                        'organizer' => [
                            '@type' => 'Organization',
                            'name' => 'PHP-PB',
                            'url' => config('app.url'),
                        ],
                    ])->values(),
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ) !!}
            </script>
        </x-slot:head>
    @endif

    <livewire:landing.header />

    <main>
        <div class="gradient-hero py-16">
            <div class="max-w-[1200px] mx-auto px-6 text-center">
                <h1 class="font-display font-bold text-4xl sm:text-5xl text-white mb-4">Eventos</h1>
                <p class="text-white/80 text-lg max-w-xl mx-auto">
                    Participe dos nossos meetups, workshops e conferências.
                </p>
            </div>
        </div>

        <livewire:events.event-list />
    </main>

    <livewire:landing.footer />
</x-layouts.app>
