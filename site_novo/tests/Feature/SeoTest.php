<?php

use App\Models\Event;
use App\Models\Post;

test('the home page has a specific meta description, canonical and organization jsonld', function () {
    $response = $this->get(route('home'))->assertOk();

    $response->assertSee('name="description" content="A PHP PB é a comunidade', false);
    $response->assertSee('<link rel="canonical" href="'.config('app.url').'/"', false);
    $response->assertSee('property="og:title"', false);
    $response->assertSee('name="twitter:card" content="summary_large_image"', false);
    $response->assertSee('"@type":"Organization"', false);
});

test('a blog post has its own meta description, og:image and blogposting jsonld', function () {
    $post = Post::factory()->create([
        'title' => 'Como testar SEO no Laravel',
    ]);

    $response = $this->get(route('blog.show', $post->slug))->assertOk();

    $response->assertSee('Como testar SEO no Laravel - PHP-PB', false);
    $response->assertSee('property="og:type" content="article"', false);
    $response->assertSee('"@type":"BlogPosting"', false);
    $response->assertSee('"headline":"Como testar SEO no Laravel"', false);
});

test('the events page includes event jsonld only when there are upcoming events', function () {
    $this->get(route('events.index'))
        ->assertOk()
        ->assertDontSee('application/ld+json', false);

    Event::factory()->create(['title' => 'Meetup PHP PB de Teste']);

    $response = $this->get(route('events.index'))->assertOk();

    $response->assertSee('"@type":"Event"', false);
    $response->assertSee('"name":"Meetup PHP PB de Teste"', false);
});

test('error pages are marked as noindex', function () {
    $this->get('/rota-que-nao-existe')
        ->assertNotFound()
        ->assertSee('name="robots" content="noindex, nofollow"', false);
});

test('the sitemap lists static pages and published posts', function () {
    $post = Post::factory()->create();

    $response = $this->get('/sitemap.xml')->assertOk();

    $response->assertHeader('Content-Type', 'application/xml');
    $response->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false);
    $response->assertSee('<loc>'.route('home').'</loc>', false);
    $response->assertSee('<loc>'.route('blog.show', $post->slug).'</loc>', false);
});
