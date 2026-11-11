<?php

namespace App\Jobs;

use App\Models\Monitor;
use App\Services\MonitorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckDomainUptimeJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;
    public int $timeout = 30;

    public function __construct(public int $monitorId)
    {
    }

    public function handle(MonitorService $service): void
    {
        $monitor = Monitor::with('domain')->find($this->monitorId);

        if (! $monitor || ! $monitor->domain) {
            return;
        }

        $service->checkUptime($monitor);
    }
}