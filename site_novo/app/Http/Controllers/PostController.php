<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('blog.index');
    }

    public function show(string $slug)
    {
        $post = Post::whereSlug($slug)->published()->with(['category', 'author'])->firstOrFail();

        return view('blog.show', ['post' => $post]);
    }
}
