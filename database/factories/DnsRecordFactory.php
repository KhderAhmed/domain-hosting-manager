<?php

namespace Database\Factories;

use App\Models\DnsRecord;
use App\Models\Domain;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DnsRecord>
 */
class DnsRecordFactory extends Factory
{
    protected $model = DnsRecord::class;

    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'type' => 'A',
            'name' => '@',
            'value' => fake()->ipv4(),
            'ttl' => 3600,
        ];
    }
}