<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\SslCertificate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SslAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_only_sees_ssl_of_their_domains(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $ownDomain = Domain::factory()->create(['user_id' => $user->id]);
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);

        SslCertificate::factory()->create([
            'domain_id' => $ownDomain->id,
            'issuer' => 'mine-issuer',
        ]);
        SslCertificate::factory()->create([
            'domain_id' => $otherDomain->id,
            'issuer' => 'other-issuer',
        ]);

        $this->actingAs($user)
            ->get(route('ssl.index'))
            ->assertOk()
            ->assertSee('mine-issuer')
            ->assertDontSee('other-issuer');
    }

    public function test_user_cannot_edit_another_users_ssl(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $other->id]);
        $ssl = SslCertificate::factory()->create(['domain_id' => $domain->id]);

        $this->actingAs($user)
            ->get(route('ssl.edit', $ssl))
            ->assertForbidden();
    }

    public function test_user_cannot_delete_another_users_ssl(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $other->id]);
        $ssl = SslCertificate::factory()->create(['domain_id' => $domain->id]);

        $this->actingAs($user)
            ->delete(route('ssl.destroy', $ssl))
            ->assertForbidden();

        $this->assertDatabaseHas('ssl_certificates', ['id' => $ssl->id]);
    }

    public function test_user_cannot_create_ssl_for_another_users_domain(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $otherDomain = Domain::factory()->create(['user_id' => $other->id]);

        $this->actingAs($user)
            ->post(route('ssl.store'), [
                'domain_id' => $otherDomain->id,
                'issuer' => 'Hacker CA',
                'valid_from' => now()->toDateString(),
                'valid_to' => now()->addYear()->toDateString(),
                'status' => 'valid',
            ])
            ->assertSessionHasErrors('domain_id');

        $this->assertDatabaseCount('ssl_certificates', 0);
    }

    public function test_user_can_create_ssl_for_own_domain(): void
    {
        $user = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->post(route('ssl.store'), [
                'domain_id' => $domain->id,
                'issuer' => "Let's Encrypt",
                'valid_from' => now()->toDateString(),
                'valid_to' => now()->addYear()->toDateString(),
                'status' => 'valid',
            ])
            ->assertRedirect(route('ssl.index'));

        $this->assertDatabaseHas('ssl_certificates', [
            'domain_id' => $domain->id,
            'issuer' => "Let's Encrypt",
        ]);
    }

    public function test_admin_sees_all_ssl(): void
    {
        $admin = User::factory()->admin()->create();
        $owner = User::factory()->create();
        $domain = Domain::factory()->create(['user_id' => $owner->id]);

        SslCertificate::factory()->create([
            'domain_id' => $domain->id,
            'issuer' => 'admin-visible-ca',
        ]);

        $this->actingAs($admin)
            ->get(route('ssl.index'))
            ->assertOk()
            ->assertSee('admin-visible-ca');
    }
}