<x-layouts.app :title="$post->title . ' - PHP-PB'">
    <livewire:landing.header />

    <main class="bg-areia">
        <!-- Hero do post -->
        <div class="relative min-h-[40vh] flex items-end gradient-hero overflow-hidden">
            @if ($post->getMainImage())
                <div class="absolute inset-0">
                    <img src="{{ $post->getMainImage() }}"
                         class="w-full h-full object-cover object-center opacity-25"
                         alt="{{ $post->title }}">
                </div>
            @endif
            <div class="relative max-w-4xl mx-auto px-6 py-16 w-full">
                @if ($post->category)
                    <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white/90 text-sm font-medium mb-4">
                        {{ $post->category->name }}
                    </span>
                @endif
                <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                    {{ $post->title }}
                </h1>
                <div class="mt-4 flex items-center gap-4 text-white/70 text-sm">
                    @if ($post->author)
                        <span class="flex items-center gap-2">
                            @if ($post->author->getAvatar())
                                <img src="{{ $post->author->getAvatar() }}"
                                     class="w-7 h-7 rounded-full object-cover"
                                     alt="{{ $post->author->name }}">
                            @endif
                            {{ $post->author->name }}
                        </span>
                        <span>·</span>
                    @endif
                    @if ($post->published_at)
                        <time datetime="{{ $post->published_at->toIso8601String() }}">
                            {{ $post->published_at->translatedFormat('d \d\e F \d\e Y') }}
                        </time>
                    @endif
                </div>
            </div>
        </div>

        <!-- Conteúdo do post -->
        <div class="max-w-4xl mx-auto px-6 py-12">
            <div class="bg-white rounded-2xl shadow-[0_4px_16px_rgba(8,45,82,.07)] p-6 sm:p-10">
                @if ($post->content_blocks)
                    <x-render-blocks :blocks="$post->content_blocks" />
                @endif

                <!-- Rodapé do post -->
                <div class="mt-16 pt-8 border-t border-cinza-claro">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        @if ($post->author)
                            <div class="flex items-center gap-4">
                                @if ($post->author->getAvatar())
                                    <img src="{{ $post->author->getAvatar() }}"
                                         class="w-14 h-14 rounded-full object-cover shrink-0"
                                         alt="{{ $post->author->name }}">
                                @endif
                                <div>
                                    <p class="font-semibold text-preto">{{ $post->author->name }}</p>
                                    @if ($post->author->bio)
                                        <p class="text-sm text-cinza">{{ $post->author->bio }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('blog.index') }}"
                           class="inline-flex items-center gap-2 text-azul-principal font-semibold hover:underline">
                            <x-phosphor-arrow-left class="w-4 h-4" />
                            Voltar ao blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <livewire:landing.footer />
</x-layouts.app>
