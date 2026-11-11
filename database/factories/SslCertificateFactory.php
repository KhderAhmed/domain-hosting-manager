<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\SslCertificate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SslCertificate>
 */
class SslCertificateFactory extends Factory
{
    protected $model = SslCertificate::class;

    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'issuer' => "Let's Encrypt",
            'valid_from' => now()->subMonth()->toDateString(),
            'valid_to' => now()->addYear()->toDateString(),
            'status' => 'valid',
        ];
    }
}