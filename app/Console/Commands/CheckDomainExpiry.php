<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;

class CheckDomainExpiry extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:check-domain-expiry';

    /**
     * The console command description.
     */
    protected $description = 'Check domains that will expire within 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domains = Domain::whereDate(
            'expiry_date',
            '<=',
            now()->addDays(30)
        )->get();

        foreach ($domains as $domain) {
            $this->info("Domain {$domain->name} will expire on {$domain->expiry_date}");
        }
    }
}