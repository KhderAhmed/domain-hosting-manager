<?php

namespace Tests\Feature;

use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_any_authenticated_user_can_view_servers_index(): void
    {
        $user = User::factory()->create();
        Server::factory()->create(['name' => 'shared-server']);

        $this->actingAs($user)
            ->get(route('servers.index'))
            ->assertOk()
            ->assertSee('shared-server');
    }

    public function test_non_admin_cannot_create_server(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('servers.create'))
            ->assertForbidden();

        $this->actingAs($user)
            ->post(route('servers.store'), [
                'name' => 'evil',
                'ip_address' => '1.2.3.4',
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('servers', ['name' => 'evil']);
    }

    public function test_admin_can_create_server(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('servers.store'), [
                'name' => 'new-server',
                'ip_address' => '1.2.3.4',
                'provider' => 'Hetzner',
                'location' => 'Berlin',
            ])
            ->assertRedirect(route('servers.index'));

        $this->assertDatabaseHas('servers', [
            'name' => 'new-server',
            'user_id' => $admin->id,
        ]);
    }

    public function test_non_admin_cannot_update_server(): void
    {
        $user = User::factory()->create();
        $server = Server::factory()->create(['name' => 'original']);

        $this->actingAs($user)
            ->patch(route('servers.update', $server), [
                'name' => 'hacked',
                'ip_address' => '9.9.9.9',
                'provider' => 'x',
                'location' => 'y',
                'status' => 'online',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('servers', [
            'id' => $server->id,
            'name' => 'original',
        ]);
    }

    public function test_non_admin_cannot_delete_server(): void
    {
        $user = User::factory()->create();
        $server = Server::factory()->create();

        $this->actingAs($user)
            ->delete(route('servers.destroy', $server))
            ->assertForbidden();

        $this->assertDatabaseHas('servers', ['id' => $server->id]);
    }
}