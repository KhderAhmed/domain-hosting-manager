<?php

namespace App\Jobs;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class SendExpiryNotificationsJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $threshold = now()->addDays(30);

        $domains = Domain::with('user')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', $threshold)
            ->where('expiry_date', '>=', now())
            ->get();

        foreach ($domains as $domain) {
            if (! $domain->user) {
                continue;
            }

            // لاحقاً: Notification class حقيقي بدل log
            logger()->info("Domain {$domain->domain_name} expires on {$domain->expiry_date} — notify {$domain->user->email}");
        }
    }
}
