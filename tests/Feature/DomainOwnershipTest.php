<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_their_own_domains_in_index(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();

        $ownDomain = Domain::factory()->create([
            'user_id' => $owner->id,
            'domain_name' => 'mine.com',
        ]);

        $otherDomain = Domain::factory()->create([
            'user_id' => $other->id,
            'domain_name' => 'notmine.com',
        ]);

        $response = $this->actingAs($owner)->get(route('domains.index'));

        $response->assertOk();
        $response->assertSee('mine.com');
        $response->assertDontSee('notmine.com');
    }

    public function test_user_cannot_view_another_users_domain(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->get(route('domains.show', $domain))
            ->assertForbidden();
    }

    public function test_user_cannot_edit_another_users_domain(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->get(route('domains.edit', $domain))
            ->assertForbidden();
    }

    public function test_user_cannot_update_another_users_domain(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create([
            'user_id' => $owner->id,
            'domain_name' => 'original.com',
        ]);

        $this->actingAs($other)
            ->patch(route('domains.update', $domain), [
                'domain_name' => 'hacked.com',
                'expiry_date' => now()->addYear()->toDateString(),
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('domains', [
            'id' => $domain->id,
            'domain_name' => 'original.com',
        ]);
    }

    public function test_user_cannot_delete_another_users_domain(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->delete(route('domains.destroy', $domain))
            ->assertForbidden();

        $this->assertDatabaseHas('domains', ['id' => $domain->id]);
    }

    public function test_user_can_create_their_own_domain(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('domains.store'), [
                'domain_name' => 'newdomain.com',
                'expiry_date' => now()->addYear()->toDateString(),
            ])
            ->assertRedirect(route('domains.index'));

        $this->assertDatabaseHas('domains', [
            'user_id' => $user->id,
            'domain_name' => 'newdomain.com',
        ]);
    }
}