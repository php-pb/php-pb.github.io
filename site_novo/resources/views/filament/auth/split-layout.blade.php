@php
    use Filament\Support\Enums\Width;

    $renderHookScopes = $livewire?->getRenderHookScopes();
    $maxContentWidth ??= (filament()->getSimplePageMaxContentWidth() ?? Width::Large);

    if (is_string($maxContentWidth)) {
        $maxContentWidth = Width::tryFrom($maxContentWidth) ?? $maxContentWidth;
    }
@endphp

<x-filament-panels::layout.base :livewire="$livewire">
    @props([
        'after' => null,
        'heading' => null,
        'subheading' => null,
    ])

    <div class="fi-login-split-layout flex min-h-screen">
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_START, scopes: $renderHookScopes) }}

        <!-- Painel de marca -->
        <div class="fi-login-brand-panel relative hidden lg:flex lg:w-[420px] xl:w-[480px] shrink-0 flex-col justify-between overflow-hidden p-12 text-white">
            <div class="relative z-10 flex items-center gap-3">
                <img src="{{ asset('images/hero/mascote.png') }}" alt="" class="h-10 w-auto">
                <span class="flex flex-col gap-0" style="font-family: 'Poppins', sans-serif;">
                    <b class="text-lg leading-none font-extrabold">PHP</b>
                    <b class="text-lg leading-none font-extrabold">PB</b>
                </span>
            </div>

            <!-- Ilustração decorativa (cena do farol usada no CTA final do site) -->
            <div class="relative z-10 w-full" aria-hidden="true">
                <img src="{{ asset('images/hero/farol-cena.png') }}" alt="" class="w-full">
                <img src="{{ asset('images/hero/mascote.png') }}" alt="" class="absolute left-[-8%] bottom-[-10%] w-[52%] drop-shadow-[0_12px_14px_rgba(8,45,82,.35)]">
            </div>

            <div class="relative z-10">
                <h1 class="mb-4 text-3xl font-bold leading-tight" style="font-family: 'Poppins', sans-serif;">
                    A comunidade PHP que conecta a Paraíba
                </h1>
                <p class="leading-relaxed text-white/80">
                    Onde desenvolvedores se conectam, aprendem e evoluem juntos desde 2012.
                </p>
            </div>

            <div class="relative z-10 flex gap-8">
                <div>
                    <div class="text-2xl font-bold" style="font-family: 'Poppins', sans-serif;">500+</div>
                    <div class="text-sm text-white/70">membros</div>
                </div>
                <div>
                    <div class="text-2xl font-bold" style="font-family: 'Poppins', sans-serif;">50+</div>
                    <div class="text-sm text-white/70">eventos</div>
                </div>
                <div>
                    <div class="text-2xl font-bold" style="font-family: 'Poppins', sans-serif;">10</div>
                    <div class="text-sm text-white/70">PHPestes</div>
                </div>
            </div>

            <!-- Onda decorativa no rodapé -->
            <svg class="absolute inset-x-0 bottom-0 z-0 h-20 w-full" viewBox="0 0 420 100" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0 60 C70 100 140 20 210 50 C280 80 350 20 420 45 L420 100 L0 100 Z" fill="#8DD0F3" opacity=".5" />
                <path d="M0 80 C90 40 170 100 260 70 C330 48 380 65 420 60 L420 100 L0 100 Z" fill="#082D52" opacity=".35" />
            </svg>
        </div>

        <!-- Formulário -->
        <div class="fi-simple-main-ctn flex-1">
            @if (($hasTopbar ?? true) && filament()->auth()->check())
                <div class="fi-simple-layout-header">
                    @if (filament()->hasDatabaseNotifications())
                        @livewire(Filament\Livewire\DatabaseNotifications::class, [
                            'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                            'position' => \Filament\Enums\DatabaseNotificationsPosition::Topbar,
                        ])
                    @endif

                    @if (filament()->hasUserMenu())
                        @livewire(Filament\Livewire\SimpleUserMenu::class)
                    @endif
                </div>
            @endif

            <main
                @class([
                    'fi-simple-main',
                    ($maxContentWidth instanceof Width) ? "fi-width-{$maxContentWidth->value}" : $maxContentWidth,
                ])
            >
                {{ $slot }}
            </main>
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::FOOTER, scopes: $renderHookScopes) }}

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIMPLE_LAYOUT_END, scopes: $renderHookScopes) }}
    </div>
</x-filament-panels::layout.base>
