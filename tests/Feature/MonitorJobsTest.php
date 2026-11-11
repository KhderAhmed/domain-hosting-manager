<?php

namespace Tests\Feature;

use App\Jobs\CheckDomainUptimeJob;
use App\Jobs\CheckSslExpiryJob;
use App\Models\Domain;
use App\Models\Monitor;
use App\Models\MonitorLog;
use App\Models\User;
use App\Services\MonitorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MonitorJobsTest extends TestCase
{
    use RefreshDatabase;

    public function test_uptime_job_writes_up_log_on_success(): void
    {
        Http::fake([
            'https://*' => Http::response('OK', 200),
        ]);

        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id, 'domain_name' => 'example.com']);
        $monitor = Monitor::factory()->create(['domain_id' => $domain->id]);

        (new CheckDomainUptimeJob($monitor->id))->handle(app(MonitorService::class));

        $this->assertDatabaseHas('monitor_logs', [
            'monitor_id' => $monitor->id,
            'status' => 'up',
            'status_code' => 200,
        ]);
    }

    public function test_uptime_job_writes_down_log_on_failure(): void
    {
        Http::fake([
            'https://*' => Http::response('Server Error', 500),
        ]);

        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id, 'domain_name' => 'failing.com']);
        $monitor = Monitor::factory()->create(['domain_id' => $domain->id]);

        (new CheckDomainUptimeJob($monitor->id))->handle(app(MonitorService::class));

        $this->assertDatabaseHas('monitor_logs', [
            'monitor_id' => $monitor->id,
            'status' => 'down',
            'status_code' => 500,
        ]);
    }

    public function test_uptime_job_writes_down_log_on_exception(): void
    {
        Http::fake(function () {
            throw new \Illuminate\Http\Client\ConnectionException('Timeout');
        });

        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id, 'domain_name' => 'timeout.com']);
        $monitor = Monitor::factory()->create(['domain_id' => $domain->id]);

        (new CheckDomainUptimeJob($monitor->id))->handle(app(MonitorService::class));

        $this->assertDatabaseHas('monitor_logs', [
            'monitor_id' => $monitor->id,
            'status' => 'down',
        ]);
    }

    public function test_ssl_job_does_nothing_when_check_fails(): void
    {
        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id, 'domain_name' => 'invalid.local']);

        (new CheckSslExpiryJob($domain->id))->handle(app(MonitorService::class));

        $this->assertDatabaseCount('ssl_certificates', 0);
    }

    public function test_scheduler_registers_jobs(): void
    {
        $this->artisan('schedule:list')
            ->assertSuccessful();
    }
}