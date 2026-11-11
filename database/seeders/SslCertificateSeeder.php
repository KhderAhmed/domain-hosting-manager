<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\SslCertificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SslCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domain = Domain::first();

        if ($domain) {
            SslCertificate::create([
                'domain_id' => $domain->id,
                'issuer' => "Let's Encrypt",
                'valid_from' => now()->subMonth(),
                'valid_to' => now()->addMonths(3),
                'status' => 'valid',

            ]);
        }
    }
}
