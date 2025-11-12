<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';
    protected $description = 'Deactivate expired user subscriptions';

    public function handle()
    {
        $now = Carbon::now();
        $count = UserSubscription::where('is_active', true)
            ->where('end_date', '<', $now)
            ->update(['is_active' => false]);

        $this->info("Expired {$count} subscription(s).");
    }
}
