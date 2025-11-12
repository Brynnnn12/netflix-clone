<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get all subscriptions for this user
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Get active subscriptions for this user
     */
    public function activeSubscriptions(): HasMany
    {
        return $this->subscriptions()->valid();
    }

    /**
     * Get watch history for this user
     */
    public function watchHistories(): HasMany
    {
        return $this->hasMany(WatchHistory::class);
    }

    /**
     * Get all watched movies
     */
    public function watchedMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'watch_histories');
    }

    /**
     * Get favorite movies
     */
    public function favoriteMovies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'favorites');
    }

    /**
     * Get all favorites for this user
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get payment orders for this user
     */
    public function paymentOrders(): HasMany
    {
        return $this->hasMany(PaymentOrder::class);
    }

    /**
     * Get current active subscription
     */
    public function currentSubscription()
    {
        return $this->subscriptions()
            ->where('is_active', true)
            ->where('end_date', '>', now())
            ->latest('end_date')
            ->first();
    }

    /**
     * Check if user has active subscription
     */
    public function hasActiveSubscription(): bool
    {
        return $this->currentSubscription() !== null;
    }

    /**
     * Get premium access movies
     */
    public function canAccessPremiumMovies(): bool
    {
        return $this->hasActiveSubscription();
    }

    /**
     * Scope: Filter by email
     */
    public function scopeFilterByEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }

    /**
     * Scope: Filter by name
     */
    public function scopeFilterByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    /**
     * Scope: Verified emails only
     */
    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Scope: Unverified emails only
     */
    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    /**
     * Scope: With active subscriptions
     */
    public function scopeWithActiveSubscriptions($query)
    {
        return $query->whereHas('subscriptions', function ($q) {
            $q->where('is_active', true)
                ->where('end_date', '>', now());
        });
    }

    /**
     * Scope: Without active subscriptions
     */
    public function scopeWithoutActiveSubscriptions($query)
    {
        return $query->doesntHave('subscriptions')
            ->orWhereHas('subscriptions', function ($q) {
                $q->where('is_active', false)
                    ->orWhere('end_date', '<=', now());
            });
    }

    /**
     * Scope: With watch history
     */
    public function scopeWithWatchHistory($query)
    {
        return $query->whereHas('watchHistories');
    }

    /**
     * Scope: With favorites
     */
    public function scopeWithFavorites($query)
    {
        return $query->whereHas('favorites');
    }

    /**
     * Scope: Active users (with recent activity)
     */
    public function scopeActive($query, $days = 30)
    {
        return $query->whereHas('watchHistories', function ($q) use ($days) {
            $q->where('last_watched_at', '>=', now()->subDays($days));
        });
    }

    /**
     * Scope: Order by creation date
     */
    public function scopeOrderByCreated($query, $direction = 'desc')
    {
        return $query->orderBy('created_at', $direction);
    }

    /**
     * Apply Spatie Query Builder filters
     */
    public static function applyQueryBuilder()
    {
        return QueryBuilder::for(self::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::callback('email_verified', function ($query, $value) {
                    if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                        $query->verified();
                    } else {
                        $query->unverified();
                    }
                }),
                AllowedFilter::callback('has_subscription', function ($query, $value) {
                    if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
                        $query->withActiveSubscriptions();
                    } else {
                        $query->withoutActiveSubscriptions();
                    }
                }),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('-created_at');
    }
}
