<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\Monitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monitor>
 */
class MonitorFactory extends Factory
{
    protected $model = Monitor::class;

    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'interval' => 5,
        ];
    }
}