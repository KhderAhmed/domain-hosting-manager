<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\HostingAccount;
use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostingAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_hosting_accounts_of_their_domains(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $server = Server::factory()->create();

        $ownDomain = Domain::factory()->create(['user_id' => $user->id]);
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);

        HostingAccount::factory()->create([
            'domain_id' => $ownDomain->id,
            'server_id' => $server->id,
            'username' => 'mine-host',
        ]);
        HostingAccount::factory()->create([
            'domain_id' => $otherDomain->id,
            'server_id' => $server->id,
            'username' => 'other-host',
        ]);

        $this->actingAs($user)
            ->get(route('hosting.index'))
            ->assertOk()
            ->assertSee('mine-host')
            ->assertDontSee('other-host');
    }

    public function test_user_cannot_edit_another_users_hosting(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $other->id]);
        $hosting = HostingAccount::factory()->create(['domain_id' => $domain->id]);

        $this->actingAs($user)
            ->get(route('hosting.edit', $hosting))
            ->assertForbidden();
    }

    public function test_user_cannot_delete_another_users_hosting(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $other->id]);
        $hosting = HostingAccount::factory()->create(['domain_id' => $domain->id]);

        $this->actingAs($user)
            ->delete(route('hosting.destroy', $hosting))
            ->assertForbidden();

        $this->assertDatabaseHas('hosting_accounts', ['id' => $hosting->id]);
    }

    public function test_user_cannot_create_hosting_for_another_users_domain(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);
        $server = Server::factory()->create();

        $this->actingAs($user)
            ->post(route('hosting.store'), [
                'domain_id' => $otherDomain->id,
                'server_id' => $server->id,
                'status' => 'active',
            ])
            ->assertSessionHasErrors('domain_id');

        $this->assertDatabaseCount('hosting_accounts', 0);
    }

    public function test_user_can_create_hosting_for_own_domain(): void
    {
        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id]);
        $server = Server::factory()->create();

        $this->actingAs($user)
            ->post(route('hosting.store'), [
                'domain_id' => $domain->id,
                'server_id' => $server->id,
                'status' => 'active',
            ])
            ->assertRedirect(route('hosting.index'));

        $this->assertDatabaseHas('hosting_accounts', [
            'domain_id' => $domain->id,
            'server_id' => $server->id,
        ]);
    }

    public function test_admin_sees_all_hosting_accounts(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        HostingAccount::factory()->create([
            'domain_id' => $domain->id,
            'username' => 'admin-visible',
        ]);

        $this->actingAs($admin)
            ->get(route('hosting.index'))
            ->assertOk()
            ->assertSee('admin-visible');
    }
}
