<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          
        'user_id'       => User::factory(),
        'domain_name'   => fake()->unique()->domainName(),
        'registrar'     => fake()->company(),
        'purchase_date' => now()->subYear()->toDateString(),
        'expiry_date'   => now()->addYear()->toDateString(),
        'auto_renew'    => false,
    ];
       
    }
}
