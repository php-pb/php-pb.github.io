@props(['text', 'level' => 'h2'])

<{{ $level }} class="font-display font-bold text-azul-marinho mt-8 mb-4 @if($level === 'h2') text-3xl @elseif($level === 'h3') text-2xl @else text-xl @endif">
    {{ $text }}
</{{ $level }}>
