<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Monitor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MonitorAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_monitors_of_their_domains(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $ownDomain = Domain::factory()->create([
            'user_id' => $user->id,
            'domain_name' => 'mine-monitor.com',
        ]);
        $otherDomain = Domain::factory()->create([
            'user_id' => $other->id,
            'domain_name' => 'other-monitor.com',
        ]);

        Monitor::factory()->create(['domain_id' => $ownDomain->id]);
        Monitor::factory()->create(['domain_id' => $otherDomain->id]);

        $this->actingAs($user)
            ->get(route('monitor.index'))
            ->assertOk()
            ->assertSee('mine-monitor.com')
            ->assertDontSee('other-monitor.com');
    }

    public function test_admin_sees_all_monitors(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = User::factory()->create();
        $domain = Domain::factory()->create([
            'user_id' => $owner->id,
            'domain_name' => 'admin-sees-this.com',
        ]);

        Monitor::factory()->create(['domain_id' => $domain->id]);

        $this->actingAs($admin)
            ->get(route('monitor.index'))
            ->assertOk()
            ->assertSee('admin-sees-this.com');
    }
}