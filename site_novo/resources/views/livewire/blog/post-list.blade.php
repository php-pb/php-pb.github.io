<div>
    <div class="gradient-hero py-16">
        <div class="max-w-[1200px] mx-auto px-6 text-center">
            <h1 class="font-display font-bold text-4xl sm:text-5xl text-white mb-4">Blog</h1>
            <p class="text-white/80 text-lg max-w-xl mx-auto">
                Artigos técnicos sobre PHP, Laravel e o ecossistema de desenvolvimento da comunidade.
            </p>
        </div>
    </div>

    <div class="bg-white border-b border-cinza-claro sticky top-[72px] z-10">
        <div class="max-w-[1200px] mx-auto px-6 py-4">
            <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                <select wire:model.live="category"
                        class="px-4 py-2 rounded-lg border border-cinza-claro bg-white text-preto text-sm focus:outline-none focus:ring-2 focus:ring-azul-principal focus:border-azul-principal">
                    <option value="">Todas as categorias</option>
                    @foreach ($categories as $cat)
                        <option wire:key="category-{{ $cat['slug'] }}" value="{{ $cat['slug'] }}">{{ $cat['name'] }}</option>
                    @endforeach
                </select>

                <select wire:model.live="order"
                        class="px-4 py-2 rounded-lg border border-cinza-claro bg-white text-preto text-sm focus:outline-none focus:ring-2 focus:ring-azul-principal focus:border-azul-principal">
                    <option value="date_desc">Mais recentes</option>
                    <option value="date_asc">Mais antigos</option>
                </select>

                <span class="text-sm text-cinza sm:ml-auto">
                    {{ $postCount }} {{ $postCount === 1 ? 'artigo' : 'artigos' }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-[1200px] mx-auto px-6 py-12 bg-areia">
        @if (count($posts) > 0)
            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article wire:key="post-{{ $post['slug'] }}" class="group bg-white rounded-2xl shadow-[0_4px_16px_rgba(8,45,82,.07)] overflow-hidden transition-all hover:-translate-y-1.5 hover:shadow-[0_10px_30px_rgba(8,45,82,.1)]">
                        <a href="{{ route('blog.show', ['slug' => $post['slug']]) }}" class="block">
                            @if ($post['main_image_upload'] || $post['main_image_url'])
                                <div class="aspect-video overflow-hidden bg-azul-fundo">
                                    <img class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                         src="{{ $post['main_image_upload'] ? \Illuminate\Support\Facades\Storage::disk('public')->url($post['main_image_upload']) : $post['main_image_url'] }}"
                                         alt="{{ $post['title'] }}"
                                         loading="lazy">
                                </div>
                            @else
                                <div class="aspect-video bg-azul-fundo flex items-center justify-center">
                                    <img src="{{ asset('images/php-pb-logo.svg') }}" class="w-24 opacity-30" alt="">
                                </div>
                            @endif
                        </a>

                        <div class="p-6">
                            @if ($post['category'])
                                <span class="inline-block px-2.5 py-1 text-xs font-semibold bg-azul-fundo text-azul-principal rounded-full mb-3">
                                    {{ $post['category']['name'] }}
                                </span>
                            @endif

                            <h2 class="font-display text-lg font-bold text-preto mb-2 leading-snug">
                                <a href="{{ route('blog.show', ['slug' => $post['slug']]) }}"
                                   class="hover:text-azul-principal transition-colors">
                                    {{ $post['title'] }}
                                </a>
                            </h2>

                            <div class="flex items-center gap-3 text-sm text-cinza mt-4">
                                @if ($post['author'])
                                    <span class="flex items-center gap-1.5">
                                        @if ($post['author']['avatar'])
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($post['author']['avatar']) }}"
                                                 class="w-5 h-5 rounded-full object-cover"
                                                 alt="{{ $post['author']['name'] }}">
                                        @endif
                                        {{ $post['author']['name'] }}
                                    </span>
                                    <span>·</span>
                                @endif
                                @if ($post['published_at'])
                                    <time>{{ \Carbon\Carbon::parse($post['published_at'])->translatedFormat('d M Y') }}</time>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($hasMore)
                <div class="mt-12 flex justify-center">
                    <button wire:click="loadMore"
                            class="inline-flex items-center gap-2 px-6 py-3 border border-azul-principal text-azul-principal font-semibold rounded-full hover:bg-azul-principal hover:text-white transition-all">
                        Carregar mais
                    </button>
                </div>
            @endif
        @else
            <div class="text-center py-24 text-cinza">
                <x-phosphor-article class="w-12 h-12 mx-auto mb-4 opacity-50" />
                <p class="text-lg font-medium">Nenhum artigo encontrado</p>
            </div>
        @endif
    </div>
</div>
