<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_all_domains_in_index(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $owner = User::factory()->create();

        Domain::factory()->create([
            'user_id' => $owner->id,
            'domain_name' => 'ownerdomain.com',
        ]);

        $response = $this->actingAs($admin)->get(route('domains.index'));

        $response->assertOk();
        $response->assertSee('ownerdomain.com');
    }

    public function test_admin_can_view_any_domain(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $owner = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($admin)
            ->get(route('domains.show', $domain))
            ->assertOk();
    }

    public function test_admin_can_update_any_domain(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $owner = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($admin)
            ->patch(route('domains.update', $domain), [
                'domain_name' => 'updated-by-admin.com',
                'expiry_date' => now()->addYear()->toDateString(),
            ])
            ->assertRedirect(route('domains.index'));

        $this->assertDatabaseHas('domains', [
            'id' => $domain->id,
            'domain_name' => 'updated-by-admin.com',
        ]);
    }

    public function test_non_admin_user_does_not_get_admin_override(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $owner = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($user)
            ->get(route('domains.show', $domain))
            ->assertForbidden();
    }
}