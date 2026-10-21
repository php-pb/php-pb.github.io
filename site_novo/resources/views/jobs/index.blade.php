<x-layouts.app title="Vagas - PHP-PB">
    <livewire:landing.header />

    <main>
        <!-- Header da seção -->
        <div class="gradient-hero py-20 pt-32">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4">Vagas</h1>
                <p class="text-white/80 text-lg max-w-xl mx-auto">
                    Oportunidades de trabalho pra desenvolvedores PHP compartilhadas pela comunidade.
                </p>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            @if ($jobs->count() > 0)
                <div class="space-y-6">
                    @foreach ($jobs as $job)
                        <div class="bg-ink-800 rounded-2xl hover:bg-ink-700 transition-all overflow-hidden">
                            <div class="flex flex-col sm:flex-row gap-6 p-6 lg:p-8">
                                @if ($job->getCompanyLogo())
                                    <img src="{{ $job->getCompanyLogo() }}" alt="{{ $job->company }}"
                                         class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-ink-900 flex items-center justify-center flex-shrink-0 text-ink-400 font-bold text-xl">
                                        {{ mb_substr($job->company, 0, 1) }}
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h2 class="font-display text-xl font-semibold text-ink-100 mb-1">{{ $job->title }}</h2>
                                    <p class="text-ink-400 mb-4">{{ $job->company }}@if ($job->location) &middot; {{ $job->location }} @endif</p>

                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="px-3 py-1 bg-accent-500/15 text-accent text-xs font-medium rounded-full">
                                            {{ $job->work_mode->getLabel() }}
                                        </span>
                                        <span class="px-3 py-1 bg-ink-900 text-ink-400 text-xs font-medium rounded-full">
                                            {{ $job->employment_type->getLabel() }}
                                        </span>
                                        <span class="px-3 py-1 bg-accent-500/15 text-accent text-xs font-medium rounded-full">
                                            {{ $job->seniority->getLabel() }}
                                        </span>
                                        @if ($job->salary_range)
                                            <span class="px-3 py-1 bg-ink-900 text-ink-400 text-xs font-medium rounded-full">
                                                {{ $job->salary_range }}
                                            </span>
                                        @endif
                                    </div>

                                    @if ($job->description)
                                        <p class="text-ink-400 mb-4">{{ $job->description }}</p>
                                    @endif

                                    <a href="{{ $job->external_url }}" target="_blank" rel="noopener"
                                       class="inline-flex items-center px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white font-medium rounded-lg transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-accent-300">
                                        Candidatar-se
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24 text-ink-400">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-lg font-medium">Nenhuma vaga disponível no momento</p>
                </div>
            @endif
        </div>
    </main>

    <livewire:landing.footer />
</x-layouts.app>
