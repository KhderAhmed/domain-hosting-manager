<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Domain;

class CheckUptime extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:check-uptime';

    /**
     * The console command description.
     */
    protected $description = 'Check if domains are online or down';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // جلب كل الدومينات من قاعدة البيانات
        $domains = Domain::all();

        foreach ($domains as $domain) {
            try {
                $response = Http::timeout(10)->get("https://{$domain->domain_name}");

                $status = $response->successful() ? 'online' : 'down';
            } catch (\Exception $e) {
                $status = 'down';
            }

            // حفظ أو عرض النتيجة
            $this->info("Domain {$domain->domain_name} is {$status}");
            
            // مثال: لو عندك عمود status في جدول domains
            // $domain->status = $status;
            // $domain->save();
        }
    }
}