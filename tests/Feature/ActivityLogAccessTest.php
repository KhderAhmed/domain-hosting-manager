<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogAccessTest extends TestCase
{
    use RefreshDatabase;

    private function makeLog(User $user, string $action = 'test action'): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'subject_type' => 'Domain',
            'subject_id' => 1,
        ]);
    }

    public function test_user_only_sees_their_own_logs(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->makeLog($user, 'my-log-action');
        $this->makeLog($other, 'other-log-action');

        $this->actingAs($user)
            ->get(route('activity-logs.index'))
            ->assertOk()
            ->assertSee('my-log-action')
            ->assertDontSee('other-log-action');
    }

    public function test_admin_sees_all_logs(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = User::factory()->create();

        $this->makeLog($owner, 'owner-action');

        $this->actingAs($admin)
            ->get(route('activity-logs.index'))
            ->assertOk()
            ->assertSee('owner-action');
    }

    public function test_guest_cannot_access_logs(): void
    {
        $this->get(route('activity-logs.index'))
            ->assertRedirect('/login');
    }
}