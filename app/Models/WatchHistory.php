<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WatchHistory extends Model
{
    protected $table = 'watch_histories';

    protected $fillable = [
        'user_id',
        'movie_id',
        'progress_percent',
        'last_watched_at',
    ];

    protected $casts = [
        'progress_percent' => 'integer',
        'last_watched_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user for this watch history
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the movie for this watch history
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * Check if movie is finished watching
     */
    public function isFinished(): bool
    {
        return $this->progress_percent >= 90;
    }

    /**
     * Check if movie is in progress
     */
    public function isInProgress(): bool
    {
        return $this->progress_percent > 0 && $this->progress_percent < 90;
    }

    /**
     * Update last watched timestamp
     */
    public function updateLastWatched($progress = null): void
    {
        if ($progress !== null) {
            $this->progress_percent = $progress;
        }
        $this->last_watched_at = now();
        $this->save();
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
     * Scope: Filter finished movies
     */
    public function scopeFinished($query)
    {
        return $query->where('progress_percent', '>=', 90);
    }

    /**
     * Scope: Filter in progress movies
     */
    public function scopeInProgress($query)
    {
        return $query->where('progress_percent', '>', 0)
            ->where('progress_percent', '<', 90);
    }

    /**
     * Scope: Filter not started movies
     */
    public function scopeNotStarted($query)
    {
        return $query->where('progress_percent', 0);
    }

    /**
     * Scope: Recently watched
     */
    public function scopeRecentlyWatched($query, $days = 7)
    {
        return $query->where('last_watched_at', '>=', now()->subDays($days))
            ->orderBy('last_watched_at', 'desc');
    }

    /**
     * Scope: Order by last watched
     */
    public function scopeOrderByLastWatched($query, $direction = 'desc')
    {
        return $query->orderBy('last_watched_at', $direction);
    }

    /**
     * Scope: Filter by progress range
     */
    public function scopeFilterByProgressRange($query, $minProgress, $maxProgress)
    {
        return $query->whereBetween('progress_percent', [$minProgress, $maxProgress]);
    }

    /**
     * Scope: Continue watching (in progress and recent)
     */
    public function scopeContinueWatching($query, $days = 30)
    {
        return $query->where('progress_percent', '>', 0)
            ->where('progress_percent', '<', 90)
            ->where('last_watched_at', '>=', now()->subDays($days))
            ->orderBy('last_watched_at', 'desc');
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
                AllowedFilter::callback('progress_min', function ($query, $value) {
                    $query->where('progress_percent', '>=', $value);
                }),
                AllowedFilter::callback('progress_max', function ($query, $value) {
                    $query->where('progress_percent', '<=', $value);
                }),
                AllowedFilter::callback('status', function ($query, $value) {
                    if ($value === 'finished') {
                        $query->where('progress_percent', '>=', 90);
                    } elseif ($value === 'in_progress') {
                        $query->where('progress_percent', '>', 0)->where('progress_percent', '<', 90);
                    } elseif ($value === 'not_started') {
                        $query->where('progress_percent', 0);
                    }
                }),
            ])
            ->allowedSorts(['user_id', 'movie_id', 'progress_percent', 'last_watched_at', 'created_at'])
            ->defaultSort('-last_watched_at');
    }
}
