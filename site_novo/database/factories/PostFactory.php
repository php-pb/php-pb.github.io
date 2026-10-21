<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence();

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'content_blocks' => [
                [
                    'type' => 'paragraph',
                    'data' => ['text' => fake()->paragraph()],
                ],
            ],
            'main_image_url' => null,
            'main_image_upload' => null,
            'category_id' => Category::factory(),
            'author_id' => User::factory(),
            'status' => PostStatus::Published,
            'published_at' => now()->subDay(),
            'is_featured' => false,
        ];
    }

    public function unpublished(): static
    {
        return $this->state([
            'status' => PostStatus::Draft,
            'published_at' => null,
        ]);
    }

    public function pending(): static
    {
        return $this->state([
            'status' => PostStatus::Pending,
            'published_at' => null,
        ]);
    }

    public function scheduled(): static
    {
        return $this->state(['published_at' => now()->addDay()]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
