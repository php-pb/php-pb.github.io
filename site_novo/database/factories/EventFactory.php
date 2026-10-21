<?php

namespace Database\Factories;

use App\Enums\EventType;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence();

        return [
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => fake()->paragraph(),
            'starts_at' => now()->addDays(fake()->numberBetween(1, 60)),
            'location' => fake()->city().', '.fake()->stateAbbr(),
            'type' => fake()->randomElement(EventType::cases()),
            'external_url' => fake()->url(),
            'banner' => null,
            'attendees_count' => fake()->numberBetween(10, 200),
            'is_featured' => false,
            'published_at' => now()->subDay(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['published_at' => null]);
    }

    public function past(): static
    {
        return $this->state(['starts_at' => now()->subDays(5)]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
