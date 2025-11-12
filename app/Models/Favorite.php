<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user for this favorite
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movie for this favorite
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Scope: Filter by user
     */
    public function scopeFilterByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by movie
     */
    public function scopeFilterByMovie($query, $movieId)
    {
        return $query->where('movie_id', $movieId);
    }

    /**
     * Scope: Newly added favorites
     */
    public function scopeNewlyAdded($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Popular in favorites
     */
    public function scopePopular($query)
    {
        return $query->withCount('movie')
            ->orderBy('movie_id', 'desc');
    }

    /**
     * Scope: Order by creation date
     */
    public function scopeOrderByCreated($query, $direction = 'desc')
    {
        return $query->orderBy('created_at', $direction);
    }

    /**
     * Scope: Get user's favorite movies
     */
    public function scopeUserFavorites($query, $userId)
    {
        return $query->where('user_id', $userId)
            ->with('movie')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Apply Spatie Query Builder filters
     */
    public static function applyQueryBuilder()
    {
        return QueryBuilder::for(self::class)
            ->with(['user', 'movie'])
            ->allowedFilters([
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('movie_id'),
            ])
            ->allowedSorts(['user_id', 'movie_id', 'created_at'])
            ->defaultSort('-created_at');
    }
}
