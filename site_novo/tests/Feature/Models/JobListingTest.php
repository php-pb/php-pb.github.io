<?php

use App\Models\JobListing;
use Illuminate\Support\Facades\Storage;

test('published scope only returns job listings with a published_at in the past', function () {
    $published = JobListing::factory()->create(['published_at' => now()->subDay()]);
    JobListing::factory()->unpublished()->create();

    expect(JobListing::published()->get())->toHaveCount(1)
        ->and(JobListing::published()->first()->id)->toBe($published->id);
});

test('active scope excludes expired job listings', function () {
    $active = JobListing::factory()->create(['expires_at' => now()->addDay()]);
    JobListing::factory()->expired()->create();
    JobListing::factory()->create(['expires_at' => null]);

    expect(JobListing::active()->get())->toHaveCount(2)
        ->and(JobListing::active()->pluck('id'))->toContain($active->id);
});

test('getCompanyLogo returns the storage url when a logo is set', function () {
    $job = JobListing::factory()->create(['company_logo' => 'jobs/logo.jpg']);

    expect($job->getCompanyLogo())->toBe(Storage::disk('public')->url('jobs/logo.jpg'));
});

test('getCompanyLogo returns null when there is no logo', function () {
    $job = JobListing::factory()->create(['company_logo' => null]);

    expect($job->getCompanyLogo())->toBeNull();
});
