<?php

namespace Tests\Feature;

use App\Models\DnsRecord;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DnsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_dns_records_of_their_domains(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $ownDomain = Domain::factory()->create(['user_id' => $user->id]);
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);

        DnsRecord::factory()->create([
            'domain_id' => $ownDomain->id,
            'name' => 'mine-record',
        ]);
        DnsRecord::factory()->create([
            'domain_id' => $otherDomain->id,
            'name' => 'other-record',
        ]);

        $this->actingAs($user)
            ->get(route('dns.index'))
            ->assertOk()
            ->assertSee('mine-record')
            ->assertDontSee('other-record');
    }

    public function test_user_cannot_edit_dns_of_another_users_domain(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);
        $dns = DnsRecord::factory()->create(['domain_id' => $otherDomain->id]);

        $this->actingAs($user)
            ->get(route('dns.edit', $dns))
            ->assertForbidden();
    }

    public function test_user_cannot_delete_dns_of_another_users_domain(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);
        $dns = DnsRecord::factory()->create(['domain_id' => $otherDomain->id]);

        $this->actingAs($user)
            ->delete(route('dns.destroy', $dns))
            ->assertForbidden();

        $this->assertDatabaseHas('dns_records', ['id' => $dns->id]);
    }

    public function test_user_cannot_create_dns_for_another_users_domain(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);

        $this->actingAs($user)
            ->post(route('dns.store'), [
                'domain_id' => $otherDomain->id,
                'type' => 'A',
                'name' => '@',
                'value' => '1.2.3.4',
            ])
            ->assertSessionHasErrors('domain_id');

        $this->assertDatabaseCount('dns_records', 0);
    }

    public function test_user_can_create_dns_for_own_domain(): void
    {
        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('dns.store'), [
                'domain_id' => $domain->id,
                'type' => 'A',
                'name' => '@',
                'value' => '1.2.3.4',
            ])
            ->assertRedirect(route('dns.index'));

        $this->assertDatabaseHas('dns_records', [
            'domain_id' => $domain->id,
            'name' => '@',
        ]);
    }

    public function test_admin_sees_all_dns_records(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        DnsRecord::factory()->create([
            'domain_id' => $domain->id,
            'name' => 'admin-visible',
        ]);

        $this->actingAs($admin)
            ->get(route('dns.index'))
            ->assertOk()
            ->assertSee('admin-visible');
    }
}