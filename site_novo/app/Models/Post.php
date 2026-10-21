<?php

namespace App\Models;

use App\Enums\PostStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content_blocks',
        'main_image_url',
        'main_image_upload',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'is_featured',
    ];

    protected $casts = [
        'content_blocks' => 'array',
        'status' => PostStatus::class,
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published)
            ->whereNotNull('published_at')
            ->whereDate('published_at', '<=', Carbon::now());
    }

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->published()->where('is_featured', true);
    }

    /**
     * @param  Builder<Post>  $query
     * @return Builder<Post>
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Pending);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getMainImage(): ?string
    {
        if ($this->main_image_upload) {
            return Storage::disk('public')->url($this->main_image_upload);
        }

        return $this->main_image_url;
    }
}
