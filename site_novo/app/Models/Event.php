<?php

namespace App\Models;

use App\Enums\EventType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'starts_at',
        'location',
        'type',
        'external_url',
        'banner',
        'attendees_count',
        'is_featured',
        'published_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'type' => EventType::class,
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->whereDate('published_at', '<=', now());
    }

    /**
     * @param  Builder<Event>  $query
     * @return Builder<Event>
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now());
    }

    public function getBanner(): ?string
    {
        if ($this->banner) {
            return Storage::disk('public')->url($this->banner);
        }

        return null;
    }

    public function speakers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
