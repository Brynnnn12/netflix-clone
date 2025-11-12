<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all movies in this category
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }

    /**
     * Scope: Filter by active movies
     */
    public function scopeWithActiveMovies($query)
    {
        return $query->whereHas('movies', function ($q) {
            $q->where('is_active', true);
        });
    }

    /**
     * Scope: Filter by name
     */
    public function scopeFilterByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    /**
     * Scope: Filter by slug
     */
    public function scopeFilterBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Scope: Order by name
     */
    public function scopeOrderByName($query, $direction = 'asc')
    {
        return $query->orderBy('name', $direction);
    }

    /**
     * Apply Spatie Query Builder filters
     */
    public static function applyQueryBuilder()
    {
        return QueryBuilder::for(self::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
            ])
            ->allowedSorts(['name', 'created_at'])
            ->defaultSort('-created_at');
    }
}
