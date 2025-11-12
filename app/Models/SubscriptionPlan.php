<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration_days',
        'description',
        'max_users',
        'quality',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer',
        'max_users' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all user subscriptions for this plan
     */
    public function userSubscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get all payment orders for this plan
     */
    public function paymentOrders(): HasMany
    {
        return $this->hasMany(PaymentOrder::class);
    }

    /**
     * Get active user subscriptions
     */
    public function activeSubscriptions(): HasMany
    {
        return $this->userSubscriptions()->where('is_active', true);
    }

    /**
     * Scope: Filter by quality
     */
    public function scopeFilterByQuality($query, $quality)
    {
        return $query->where('quality', $quality);
    }

    /**
     * Scope: Filter by price range
     */
    public function scopeFilterByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Scope: Filter by name
     */
    public function scopeFilterByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    /**
     * Scope: Order by price
     */
    public function scopeOrderByPrice($query, $direction = 'asc')
    {
        return $query->orderBy('price', $direction);
    }

    /**
     * Scope: Only premium plans
     */
    public function scopePremiumPlans($query)
    {
        return $query->whereNotIn('name', ['Basic']);
    }

    /**
     * Scope: Filter by max users
     */
    public function scopeFilterByMaxUsers($query, $maxUsers)
    {
        return $query->where('max_users', '>=', $maxUsers);
    }

    /**
     * Scope: Filter by duration days
     */
    public function scopeFilterByDuration($query, $days)
    {
        return $query->where('duration_days', $days);
    }

    /**
     * Apply Spatie Query Builder filters
     */
    public static function applyQueryBuilder()
    {
        return QueryBuilder::for(self::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::exact('quality'),
                AllowedFilter::callback('price_min', function ($query, $value) {
                    $query->where('price', '>=', $value);
                }),
                AllowedFilter::callback('price_max', function ($query, $value) {
                    $query->where('price', '<=', $value);
                }),
                AllowedFilter::callback('max_users', function ($query, $value) {
                    $query->where('max_users', '>=', $value);
                }),
            ])
            ->allowedSorts(['name', 'price', 'duration_days', 'created_at'])
            ->defaultSort('-created_at');
    }
}
