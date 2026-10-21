<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($staticRoutes as $item)
    <url>
        <loc>{{ $item['route'] }}</loc>
        <changefreq>{{ $item['changefreq'] }}</changefreq>
        <priority>{{ $item['priority'] }}</priority>
    </url>
@endforeach
@foreach ($posts as $post)
    <url>
        <loc>{{ route('blog.show', $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
@endforeach
</urlset>
