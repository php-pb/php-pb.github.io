<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $posts = Post::published()->orderBy('published_at', 'desc')->get(['slug', 'updated_at']);

        $staticRoutes = [
            ['route' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['route' => route('blog.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['route' => route('events.index'), 'priority' => '0.8', 'changefreq' => 'daily'],
            ['route' => route('jobs.index'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['route' => route('speakers.index'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        $xml = view('sitemap', [
            'staticRoutes' => $staticRoutes,
            'posts' => $posts,
        ])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
