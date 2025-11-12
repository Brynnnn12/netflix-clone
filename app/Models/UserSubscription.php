<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'start_date',
        'end_date',
        'is_active',
        'midtrans_order_id',
        'payment_status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user for this subscription
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan for this subscription
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Get the payment order for this subscription
     */
    public function paymentOrder(): BelongsTo
    {
        return $this->belongsTo(PaymentOrder::class, 'midtrans_order_id', 'order_id');
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return Carbon::now()->isAfter($this->end_date);
    }

    /**
     * Check if subscription is active and not expired
     */
    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired();
    }

    /**
     * Get days remaining
     */
    public function daysRemaining(): int
    {
        if ($this->isExpired()) {
            return 0;
        }
        return Carbon::now()->diffInDays($this->end_date);
    }

    /**
     * Scope: Filter active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter valid subscriptions (active and not expired)
     */
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where('end_date', '>', now());
    }

    /**
     * Scope: Filter expired subscriptions
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<=', now());
    }

    /**
     * Scope: Filter by user
     */
    public function scopeFilterByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by subscription plan
     */
    public function scopeFilterByPlan($query, $planId)
    {
        return $query->where('subscription_plan_id', $planId);
    }

    /**
     * Scope: Filter by payment status
     */
    public function scopeFilterByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate]);
    }

    /**
     * Scope: Expiring soon (within X days)
     */
    public function scopeExpiringWithinDays($query, $days = 7)
    {
        return $query->where('is_active', true)
            ->where('end_date', '>', now())
            ->where('end_date', '<=', now()->addDays($days));
    }

    /**
     * Scope: With pending payment
     */
    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope: With successful payment
     */
    public function scopeSuccessfulPayment($query)
    {
        return $query->where('payment_status', 'success');
    }

    /**
     * Apply Spatie Query Builder filters
     */
    public static function applyQueryBuilder()
    {
        return QueryBuilder::for(self::class)
            ->with(['user', 'subscriptionPlan'])
            ->allowedFilters([
                AllowedFilter::exact('user_id'),
                AllowedFilter::exact('subscription_plan_id'),
                AllowedFilter::exact('payment_status'),
                AllowedFilter::callback('is_active', function ($query, $value) {
                    $query->where('is_active', filter_var($value, FILTER_VALIDATE_BOOLEAN));
                }),
                AllowedFilter::callback('status', function ($query, $value) {
                    if ($value === 'valid') {
                        $query->where('is_active', true)->where('end_date', '>', now());
                    } elseif ($value === 'expired') {
                        $query->where('end_date', '<=', now());
                    }
                }),
            ])
            ->allowedSorts(['user_id', 'start_date', 'end_date', 'created_at'])
            ->defaultSort('-created_at');
    }
}
