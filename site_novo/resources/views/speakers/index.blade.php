<x-layouts.app title="Palestrantes - PHP-PB">
    <livewire:landing.header />

    <main>
        <!-- Header da seção -->
        <div class="gradient-hero py-20 pt-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">Palestrantes</h1>
                <p class="text-white/80 text-lg max-w-xl mx-auto">
                    Pessoas que já compartilharam conhecimento nos eventos da comunidade.
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if ($speakers->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($speakers as $speaker)
                        <div class="group bg-ink-900 rounded-2xl p-8 hover:bg-ink-800 transition-all">
                            <!-- Avatar -->
                            <div class="relative inline-block mb-6">
                                @if ($speaker->getAvatar())
                                    <img src="{{ $speaker->getAvatar() }}" alt="{{ $speaker->name }}"
                                         class="w-24 h-24 rounded-2xl object-cover">
                                @else
                                    <div class="w-24 h-24 rounded-2xl bg-ink-800 flex items-center justify-center text-ink-400 font-bold text-2xl">
                                        {{ mb_substr($speaker->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <h2 class="font-display text-xl font-semibold text-ink-100 mb-1">{{ $speaker->name }}</h2>
                            @if ($speaker->cargo)
                                <p class="text-accent text-sm font-medium mb-4">{{ $speaker->cargo }}</p>
                            @endif
                            @if ($speaker->bio)
                                <p class="text-ink-400 text-sm mb-6">{{ $speaker->bio }}</p>
                            @endif

                            <!-- Stack -->
                            @if ($speaker->stack)
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @foreach ($speaker->stack as $tech)
                                        <span class="px-3 py-1 bg-ink-800 text-ink-400 text-xs font-medium rounded-full">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Eventos -->
                            @if ($speaker->speakingEvents->isNotEmpty())
                                <div class="mb-6 text-sm text-ink-400">
                                    <p class="font-medium text-ink-100 mb-1">Palestrou em:</p>
                                    <ul class="space-y-1">
                                        @foreach ($speaker->speakingEvents as $event)
                                            <li>{{ $event->title }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Social Links -->
                            @if ($speaker->github_url || $speaker->linkedin_url)
                                <div class="flex gap-3">
                                    @if ($speaker->github_url)
                                        <a href="{{ $speaker->github_url }}" target="_blank" rel="noopener"
                                           class="flex-1 flex items-center justify-center px-4 py-2 bg-ink-800 hover:bg-ink-700 text-ink-400 rounded-lg transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    @if ($speaker->linkedin_url)
                                        <a href="{{ $speaker->linkedin_url }}" target="_blank" rel="noopener"
                                           class="flex-1 flex items-center justify-center px-4 py-2 bg-ink-800 hover:bg-ink-700 text-ink-400 rounded-lg transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent-400">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24 text-ink-400">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-lg font-medium">Nenhum palestrante cadastrado ainda</p>
                </div>
            @endif
        </div>
    </main>

    <livewire:landing.footer />
</x-layouts.app>
