<?php

namespace Database\Factories;

use App\Enums\EmploymentType;
use App\Enums\SeniorityLevel;
use App\Enums\WorkMode;
use App\Models\JobListing;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobListingFactory extends Factory
{
    protected $model = JobListing::class;

    public function definition(): array
    {
        $title = fake()->unique()->jobTitle();

        return [
            'title' => $title,
            'slug' => str($title)->slug().'-'.fake()->unique()->numerify('###'),
            'company' => fake()->company(),
            'company_logo' => null,
            'location' => fake()->city().', '.fake()->stateAbbr(),
            'work_mode' => fake()->randomElement(WorkMode::cases()),
            'employment_type' => fake()->randomElement(EmploymentType::cases()),
            'seniority' => fake()->randomElement(SeniorityLevel::cases()),
            'salary_range' => null,
            'description' => fake()->paragraph(),
            'external_url' => fake()->url(),
            'published_at' => now()->subDay(),
            'expires_at' => null,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['published_at' => null]);
    }

    public function expired(): static
    {
        return $this->state(['expires_at' => now()->subDay()]);
    }
}
