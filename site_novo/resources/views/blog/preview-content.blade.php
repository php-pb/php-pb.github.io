<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
    @vite(['resources/css/app.css'])
    @livewireStyles
</head>
<body class="bg-white text-gray-900 antialiased">
    <div class="max-w-4xl mx-auto px-4 py-12">
        @if (!empty($content_blocks))
            <x-render-blocks :blocks="$content_blocks" />
        @else
            <p class="text-gray-400 italic">Nenhum bloco de conteúdo ainda.</p>
        @endif
    </div>
    @livewireScripts
</body>
</html>
