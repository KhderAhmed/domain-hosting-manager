<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckSSL extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:check-ssl';

    /**
     * The console command description.
     */
    protected $description = 'Check SSL certificate expiry date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = "google.com";

        $context = stream_context_create([
            "ssl" => [
                "capture_peer_cert" => true
            ]
        ]);

        $client = stream_socket_client(
            "ssl://{$domain}:443",
            $errno,
            $errstr,
            30,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$client) {
            $this->error("Connection failed: $errstr ($errno)");
            return;
        }

        $params = stream_context_get_params($client);
        $cert = $params["options"]["ssl"]["peer_certificate"];

        $certificate = openssl_x509_parse($cert);

        $expiry = date('Y-m-d', $certificate['validTo_time_t']);

        $this->info("SSL for {$domain} expires on: {$expiry}");
    }
}