@props(['image' => null, 'url' => null, 'alt' => '', 'caption' => null, 'ratio' => '16-9'])

@php
    $src = $image ? \Illuminate\Support\Facades\Storage::disk('public')->url($image) : $url;
    $ratioClass = \App\Filament\Blocks\Image::getRatioClass($ratio ?: '16-9');
@endphp

@if ($src)
    <div class="my-8">
        @if ($caption)
            <figure>
                <img class="w-full {{ $ratioClass }} object-cover object-center rounded-lg"
                     src="{{ $src }}" alt="{{ $alt }}">
                <figcaption class="mt-2 text-center text-sm text-cinza">
                    {{ $caption }}
                </figcaption>
            </figure>
        @else
            <img class="w-full {{ $ratioClass }} object-cover object-center rounded-lg"
                 src="{{ $src }}" alt="{{ $alt }}">
        @endif
    </div>
@endif
