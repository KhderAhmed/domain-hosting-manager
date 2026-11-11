<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\HostingAccount;
use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HostingAccount>
 */
class HostingAccountFactory extends Factory
{
    protected $model = HostingAccount::class;

    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'server_id' => Server::factory(),
            'username' => fake()->userName(),
            'panel' => 'cPanel',
            'disk_usage' => fake()->numberBetween(100, 10000),
            'bandwidth_usage' => fake()->numberBetween(100, 50000),
            'status' => 'active',
        ];
    }
}