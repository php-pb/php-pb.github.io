<?php

namespace App\Livewire\Blog;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    const ITEMS_PER_PAGE = 9;

    public $categories;

    public $postCount = 0;

    public $posts = [];

    public $hasMore = false;

    public $page = 1;

    public string $category = '';

    public string $order = 'date_desc';

    protected $queryString = [
        'category' => ['except' => ''],
        'order' => ['except' => 'date_desc'],
    ];

    public function mount(): void
    {
        $this->categories = Category::orderBy('name')->get();
        $this->loadPosts();
    }

    public function updatedCategory(): void
    {
        $this->page = 1;
        $this->posts = [];
        $this->loadPosts();
    }

    public function updatedOrder(): void
    {
        $this->page = 1;
        $this->posts = [];
        $this->loadPosts();
    }

    public function loadMore(): void
    {
        $this->page++;
        $this->loadPosts(append: true);
    }

    private function loadPosts(bool $append = false): void
    {
        $query = Post::published()->with(['category', 'author']);

        if ($this->category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        $query->orderBy('published_at', $this->order === 'date_asc' ? 'asc' : 'desc');

        $this->postCount = $query->count();

        $paginated = $query->forPage($this->page, self::ITEMS_PER_PAGE)->get();

        $this->posts = $append
            ? array_merge($this->posts, $paginated->toArray())
            : $paginated->toArray();

        $this->hasMore = ($this->page * self::ITEMS_PER_PAGE) < $this->postCount;
    }

    public function render()
    {
        return view('livewire.blog.post-list');
    }
}
