<x-layouts.app title="Acesso restrito - PHP-PB">
    <livewire:landing.header />

    <main class="bg-areia">
        <div class="max-w-[1200px] mx-auto px-6 py-20 lg:py-28 grid grid-cols-1 lg:grid-cols-2 items-center gap-12">
            <div class="order-2 lg:order-1">
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">Erro 403</p>
                <h1 class="font-display font-extrabold text-5xl sm:text-6xl leading-[0.98] tracking-[-0.03em] text-preto mb-6">
                    Acesso<br><span class="text-azul-principal">restrito.</span>
                </h1>
                <p class="max-w-[420px] text-[14.5px] text-[#334155] mb-9">
                    Você não tem permissão pra acessar esta área. Se acha que isso é um engano,
                    fala com quem administra a comunidade.
                </p>

                <div class="flex flex-wrap gap-3.5">
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2.5 px-5.5 py-3.5 rounded-full bg-azul-marinho hover:bg-[#0b3b6c] text-white font-semibold text-sm transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)]">
                        Voltar para o início
                        <x-phosphor-arrow-right class="w-4 h-4" />
                    </a>

                    @auth
                        <a href="/membro"
                           class="inline-flex items-center gap-2.5 px-5.5 py-3.5 rounded-full border-[1.5px] border-azul-principal text-azul-principal font-semibold text-sm transition-all hover:bg-azul-fundo">
                            Ir pro meu painel
                        </a>
                    @endauth
                </div>
            </div>

            <div class="order-1 lg:order-2 relative mx-auto w-full max-w-md" aria-hidden="true">
                <img src="{{ asset('images/hero/farol-cena.png') }}" alt="" class="w-full">
                <img src="{{ asset('images/hero/mascote.png') }}" alt="" class="absolute left-[-6%] bottom-[-6%] w-[48%] drop-shadow-[0_12px_14px_rgba(8,45,82,.25)]">
                <span class="absolute right-[2%] top-[-6%] font-script text-azul-marinho text-4xl -rotate-6">403</span>
            </div>
        </div>
    </main>

    <livewire:landing.footer />
</x-layouts.app>
