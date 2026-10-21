@props(['event', 'index' => 0])

@php $isPast = $event->starts_at->isPast(); @endphp

<article {{ $attributes->merge(['class' => 'relative snap-start rounded-[10px] overflow-hidden bg-[#0c3a68] border border-white/[0.08] transition-transform hover:-translate-y-1']) }}>
    @if ($isPast)
        <div class="absolute top-0 right-0 z-[1] bg-white/15 backdrop-blur-sm text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg">
            ENCERRADO
        </div>
    @endif
    <div @class([
        'aspect-[16/10] bg-cover bg-center',
        'opacity-60' => $isPast,
        'bg-[radial-gradient(circle_at_30%_40%,#3a6a9c,#0a2a4a_70%)]' => $index % 4 === 0,
        'bg-[radial-gradient(circle_at_70%_30%,#4b7aa6,#0a2a4a_70%)]' => $index % 4 === 1,
        'bg-[radial-gradient(circle_at_50%_60%,#2f5f94,#07223f_70%)]' => $index % 4 === 2,
        'bg-[radial-gradient(circle_at_20%_70%,#3f6e9e,#08254a_70%)]' => $index % 4 === 3,
    ]) @style([
        "background-image: url('{$event->getBanner()}')" => $event->getBanner(),
    ])></div>
    <div class="p-[10px_12px_12px] grid gap-px">
        <h4 class="text-white text-[12.5px] font-semibold">{{ $event->title }}</h4>
        <span class="text-[11px] text-[#b6c9de]">{{ $event->location }}</span>
        <time class="text-[11px] text-azul-claro">{{ mb_convert_case($event->starts_at->translatedFormat('M Y'), MB_CASE_TITLE, 'UTF-8') }}</time>
    </div>
</article>
