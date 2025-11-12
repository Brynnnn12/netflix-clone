<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PaymentOrder extends Model
{
    protected $table = 'payment_orders';

    protected $fillable = [
        'order_id',
        'user_id',
        'subscription_plan_id',
        'amount',
        'status',
        'snap_response',
        'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'snap_response' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Get the user for this payment order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription plan for this payment order
     */
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Get the user subscription for this payment
     */
    public function userSubscription(): HasOne
    {
        return $this->hasOne(UserSubscription::class, 'midtrans_order_id', 'order_id');
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is settled
     */
    public function isSettled(): bool
    {
        return $this->status === 'settlement';
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'settlement';
    }

    /**
     * Check if payment is expired
     */
    public function isExpired(): bool
    {
        return $this->status === 'expire';
    }

    /**
     * Check if payment is cancelled
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancel';
    }

    /**
     * Scope: Filter by status
     */
    public function scopeFilterByStatus($query, $status)
    {
        return $query->where('status', $status);
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
     * Scope: Filter by order ID
     */
    public function scopeFilterByOrderId($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    /**
     * Scope: Filter pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Filter settled payments
     */
    public function scopeSettled($query)
    {
        return $query->where('status', 'settlement');
    }

    /**
     * Scope: Filter successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->where('status', 'settlement');
    }

    /**
     * Scope: Filter expired payments
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expire');
    }

    /**
     * Scope: Filter cancelled payments
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancel');
    }

    /**
     * Scope: Filter by amount range
     */
    public function scopeFilterByAmountRange($query, $minAmount, $maxAmount)
    {
        return $query->whereBetween('amount', [$minAmount, $maxAmount]);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: Recent payments
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Filter by transaction ID
     */
    public function scopeFilterByTransactionId($query, $transactionId)
    {
        return $query->where('transaction_id', $transactionId);
    }

    /**
     * Scope: Total revenue by status
     */
    public function scopeTotalRevenue($query)
    {
        return $query->where('status', 'settlement')->sum('amount');
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
                AllowedFilter::exact('status'),
                AllowedFilter::partial('order_id'),
                AllowedFilter::partial('transaction_id'),
                AllowedFilter::callback('amount_min', function ($query, $value) {
                    $query->where('amount', '>=', $value);
                }),
                AllowedFilter::callback('amount_max', function ($query, $value) {
                    $query->where('amount', '<=', $value);
                }),
            ])
            ->allowedSorts(['order_id', 'user_id', 'amount', 'status', 'created_at'])
            ->defaultSort('-created_at');
    }
}
