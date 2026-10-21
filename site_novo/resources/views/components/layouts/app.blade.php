@props([
    'title' => null,
    'description' => 'A PHP PB é a comunidade de desenvolvedores PHP da Paraíba. Conectamos pessoas, compartilhamos conhecimento e fortalecemos o ecossistema PHP no nosso estado.',
    'image' => null,
    'type' => 'website',
    'noindex' => false,
])

@php
    $pageTitle = $title ?? config('app.name');
    $ogImage = $image ?? asset('images/hero/farol-cena.png');
    $canonical = rtrim(config('app.url'), '/').request()->getRequestUri();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="{{ $description }}">
        <link rel="canonical" href="{{ $canonical }}">
        @if ($noindex)
            <meta name="robots" content="noindex, nofollow">
        @endif

        <title>{{ $pageTitle }}</title>

        <!-- Open Graph -->
        <meta property="og:type" content="{{ $type }}">
        <meta property="og:site_name" content="PHP-PB">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:url" content="{{ $canonical }}">
        <meta property="og:locale" content="pt_BR">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $description }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&family=Satisfy&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        {{ $head ?? '' }}
    </head>
    <body class="antialiased bg-areia text-preto font-sans">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
