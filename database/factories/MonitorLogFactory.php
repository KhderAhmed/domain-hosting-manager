<?php

namespace Database\Factories;

use App\Models\Monitor;
use App\Models\MonitorLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonitorLog>
 */
class MonitorLogFactory extends Factory
{
    protected $model = MonitorLog::class;

    public function definition(): array
    {
        return [
            'monitor_id' => Monitor::factory(),
            'status' => 'up',
            'response_time_ms' => fake()->numberBetween(50, 500),
            'status_code' => 200,
            'error_message' => null,
        ];
    }

    public function down(): static
    {
        return $this->state(fn () => [
            'status' => 'down',
            'status_code' => 500,
            'error_message' => 'Connection timeout',
        ]);
    }
}