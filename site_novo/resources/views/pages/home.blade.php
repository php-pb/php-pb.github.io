<x-layouts.app
    title="PHP-PB - Comunidade PHP da Paraíba"
    description="A PHP PB é a comunidade de desenvolvedores PHP da Paraíba. Conectamos pessoas, compartilhamos conhecimento e fortalecemos o ecossistema PHP no nosso estado desde 2012."
>
    <x-slot:head>
        <script type="application/ld+json">
            {!! json_encode([
                '@'.'context' => 'https://schema.org',
                '@type' => 'Organization',
                'name' => 'PHP-PB',
                'alternateName' => 'Comunidade PHP da Paraíba',
                'url' => config('app.url'),
                'logo' => asset('images/hero/mascote.png'),
                'description' => 'Comunidade de desenvolvedores PHP da Paraíba, promovendo meetups, conteúdo e networking desde 2012.',
                'sameAs' => [
                    'https://github.com/php-pb',
                    'https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t',
                    'https://twitter.com/phppb',
                    'https://www.facebook.com/groups/php.pb',
                ],
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    </x-slot:head>

    <livewire:landing.header />

    <main>
        <livewire:landing.hero-v2 />
        <livewire:landing.stats />
        <livewire:landing.about />
        <livewire:landing.pillars />
        <livewire:landing.events-timeline />
        <livewire:landing.community />
        <livewire:landing.blog-preview />
        <livewire:landing.join />
        {{-- Patrocinadores ocultos até termos patrocinadores reais confirmados --}}
        {{-- <livewire:landing.sponsors /> --}}
        <livewire:landing.partners />
        <livewire:landing.cta-final />
    </main>

    <livewire:landing.footer />
</x-layouts.app>
