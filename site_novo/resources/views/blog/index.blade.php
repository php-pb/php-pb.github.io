<x-layouts.app
    title="Blog - PHP-PB"
    description="Artigos técnicos sobre PHP, Laravel e o ecossistema de desenvolvimento, escritos pela comunidade PHP da Paraíba."
>
    <livewire:landing.header />

    <main>
        @livewire('blog.post-list')
    </main>

    <livewire:landing.footer />
</x-layouts.app>
