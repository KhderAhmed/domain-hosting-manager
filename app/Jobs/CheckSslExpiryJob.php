<?php

namespace App\Jobs;

use App\Models\Domain;
use App\Models\SslCertificate;
use App\Services\MonitorService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckSslExpiryJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;
    public int $timeout = 30;

    public function __construct(public int $domainId)
    {
    }

    public function handle(MonitorService $service): void
    {
        $domain = Domain::find($this->domainId);

        if (! $domain) {
            return;
        }

        $info = $service->checkSsl($domain);

        if (! $info) {
            return;
        }

        $status = now()->parse($info['valid_to'])->isPast() ? 'expired' : 'valid';

        SslCertificate::updateOrCreate(
            ['domain_id' => $domain->id],
            [
                'issuer' => $info['issuer'],
                'valid_from' => $info['valid_from'],
                'valid_to' => $info['valid_to'],
                'status' => $status,
            ]
        );
    }
}