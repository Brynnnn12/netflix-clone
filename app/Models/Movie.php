<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'thumbnail',
        'video_url',
        'duration',
        'rating',
        'is_premium',
        'is_active',
    ];

    protected $casts = [
        'duration' => 'integer',
        'rating' => 'decimal:1',
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the category for this movie
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all watch histories for this movie
     */
    public function watchHistories(): HasMany
    {
        return $this->hasMany(WatchHistory::class);
    }

    /**
     * Get all favorites for this movie
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get all users who favorited this movie
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * Get all users who watched this movie
     */
    public function watchedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'watch_histories');
    }

    /**
     * Scope: Filter by active movies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter by premium movies
     */
    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    /**
     * Scope: Filter by free movies
     */
    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    /**
     * Scope: Filter by category
     */
    public function scopeFilterByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope: Filter by title
     */
    public function scopeFilterByTitle($query, $title)
    {
        return $query->where('title', 'like', "%{$title}%");
    }

    /**
     * Scope: Filter by slug
     */
    public function scopeFilterBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope: Filter by rating minimum
     */
    public function scopeMinimumRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Scope: Filter by duration range
     */
    public function scopeFilterByDuration($query, $minMinutes, $maxMinutes)
    {
        return $query->whereBetween('duration', [$minMinutes, $maxMinutes]);
    }

    /**
     * Scope: Order by rating
     */
    public function scopeOrderByRating($query, $direction = 'desc')
    {
        return $query->orderBy('rating', $direction);
    }

    /**
     * Scope: Order by duration
     */
    public function scopeOrderByDuration($query, $direction = 'asc')
    {
        return $query->orderBy('duration', $direction);
    }

    /**
     * Scope: Most watched movies
     */
    public function scopeMostWatched($query)
    {
        return $query->withCount('watchHistories')
            ->orderBy('watch_histories_count', 'desc');
    }

    /**
     * Scope: Most favorited movies
     */
    public function scopeMostFavorited($query)
    {
        return $query->withCount('favorites')
            ->orderBy('favorites_count', 'desc');
    }

    /**
     * Apply Spatie Query Builder filters
     */
    public static function applyQueryBuilder()
    {
        return QueryBuilder::for(self::class)
            ->with('category')
            ->allowedFilters([
                AllowedFilter::partial('title'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::callback('is_premium', function ($query, $value) {
                    $query->where('is_premium', filter_var($value, FILTER_VALIDATE_BOOLEAN));
                }),
                AllowedFilter::callback('is_active', function ($query, $value) {
                    $query->where('is_active', filter_var($value, FILTER_VALIDATE_BOOLEAN));
                }),
                AllowedFilter::callback('min_rating', function ($query, $value) {
                    $query->where('rating', '>=', $value);
                }),
            ])
            ->allowedSorts(['title', 'rating', 'duration', 'created_at'])
            ->defaultSort('-created_at');
    }
}
