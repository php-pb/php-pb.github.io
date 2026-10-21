<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component {
    public $recentPosts = [];

    public function mount(): void
    {
        $this->recentPosts = Post::published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();
    }
};
?>

<section id="conteudos" class="pt-20 pb-10 bg-areia">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-5 lg:gap-20 mb-7.5">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-azul-principal mb-3.5">Conteúdos</p>
                <h2 class="font-display text-[clamp(28px,3.2vw,38px)] font-bold text-preto">
                    Conhecimento<br>sem fronteiras.
                </h2>
                <p class="mt-3 max-w-[460px] text-[13.5px] text-cinza">
                    Artigos, vídeos, guias e materiais produzidos pela comunidade para a comunidade.
                </p>
            </div>

            <div class="relative hidden lg:block w-[300px] h-[170px] shrink-0" aria-hidden="true">
                <img src="{{ asset('images/hero/sol.png') }}" alt="" class="absolute w-20 right-[90px] top-0">
                <img src="{{ asset('images/hero/nuvem.png') }}" alt="" class="absolute w-[100px] left-5 top-2.5 opacity-60">
                <img src="{{ asset('images/hero/farol.png') }}" alt="" class="absolute w-[190px] left-5 bottom-0">
                <img src="{{ asset('images/hero/cacto.png') }}" alt="" class="absolute w-[62px] right-1.5 bottom-0">
            </div>
        </div>

        @if ($recentPosts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5.5">
                @foreach ($recentPosts as $i => $post)
                    <article class="bg-white rounded-xl overflow-hidden shadow-[0_4px_16px_rgba(8,45,82,.07)] transition-all hover:-translate-y-1.5 hover:shadow-[0_10px_30px_rgba(8,45,82,.1)]">
                        @if ($post->getMainImage())
                            <div class="aspect-[16/7.5] bg-cover bg-center" style="background-image: url('{{ $post->getMainImage() }}')"></div>
                        @else
                            <div @class([
                                'aspect-[16/7.5] grid place-items-center text-azul-claro text-4xl',
                                'bg-[linear-gradient(135deg,#0b1a2e,#12345b)]' => $i % 3 === 0,
                                'bg-[linear-gradient(135deg,#0a1b2f,#123a5d)]' => $i % 3 === 1,
                                'bg-[linear-gradient(135deg,#0d223b,#16406a)]' => $i % 3 === 2,
                            ])>
                                @if ($i % 3 === 0)
                                    <span class="font-mono text-[22px] text-[#6fb7ee]">&lt;?php</span>
                                @elseif ($i % 3 === 1)
                                    <x-phosphor-stack class="w-10 h-10" />
                                @else
                                    <x-phosphor-git-branch class="w-10 h-10" />
                                @endif
                            </div>
                        @endif

                        <div class="p-[16px_18px_18px] grid gap-2">
                            <em class="not-italic w-fit text-[9.5px] font-semibold uppercase tracking-[0.08em] text-azul-principal bg-azul-fundo border border-azul-principal/25 px-2 py-0.5 rounded">
                                {{ $post->category?->name ?? 'Artigo' }}
                            </em>
                            <h4 class="text-[15px] font-semibold leading-[1.25] text-preto">
                                {{ $post->title }}
                            </h4>
                            <a href="{{ route('blog.show', $post->slug) }}" class="group inline-flex items-center gap-1.5 text-xs font-semibold text-azul-principal mt-1">
                                Ler agora
                                <x-phosphor-arrow-right class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" />
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <p class="text-center text-cinza py-10">Nenhum artigo publicado ainda. Em breve!</p>
        @endif

        <div class="text-center mt-9">
            <a href="{{ route('blog.index') }}"
               class="inline-flex items-center gap-2.5 px-[18px] py-[11px] rounded-full bg-azul-principal hover:bg-[#1779bb] text-white font-semibold text-[13px] transition-all hover:-translate-y-0.5 hover:shadow-[0_8px_20px_rgba(30,142,219,.25)]">
                Ver todos os conteúdos
                <x-phosphor-arrow-right class="w-4 h-4" />
            </a>
        </div>
    </div>
</section>
