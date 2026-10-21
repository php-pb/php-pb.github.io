<?php

namespace App\Models;

use App\Enums\EmploymentType;
use App\Enums\SeniorityLevel;
use App\Enums\WorkMode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'company',
        'company_logo',
        'location',
        'work_mode',
        'employment_type',
        'seniority',
        'salary_range',
        'description',
        'external_url',
        'published_at',
        'expires_at',
    ];

    protected $casts = [
        'work_mode' => WorkMode::class,
        'employment_type' => EmploymentType::class,
        'seniority' => SeniorityLevel::class,
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * @param  Builder<JobListing>  $query
     * @return Builder<JobListing>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->whereDate('published_at', '<=', now());
    }

    /**
     * @param  Builder<JobListing>  $query
     * @return Builder<JobListing>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where(fn (Builder $q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    public function getCompanyLogo(): ?string
    {
        if ($this->company_logo) {
            return Storage::disk('public')->url($this->company_logo);
        }

        return null;
    }
}
