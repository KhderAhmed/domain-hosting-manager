<?php

namespace App\Services;

use App\Models\Domain;
use App\Models\Monitor;
use App\Models\MonitorLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonitorService
{
    public function checkUptime(Monitor $monitor): MonitorLog
    {
        $domain = $monitor->domain;
        $url = 'https://' . $domain->domain_name;

        $start = microtime(true);

        try {
            $response = Http::timeout(15)
                ->withOptions(['allow_redirects' => ['max' => 5]])
                ->get($url);

            $responseTime = (int) ((microtime(true) - $start) * 1000);

            return MonitorLog::create([
                'monitor_id' => $monitor->id,
                'status' => $response->successful() ? 'up' : 'down',
                'response_time_ms' => $responseTime,
                'status_code' => $response->status(),
                'error_message' => $response->successful() ? null : 'HTTP ' . $response->status(),
            ]);
        } catch (\Throwable $e) {
            Log::warning("Uptime check failed for {$domain->domain_name}: {$e->getMessage()}");

            return MonitorLog::create([
                'monitor_id' => $monitor->id,
                'status' => 'down',
                'response_time_ms' => null,
                'status_code' => null,
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    public function checkSsl(Domain $domain): ?array
    {
        $host = $domain->domain_name;
        $port = 443;
        $timeout = 10;

        $context = stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        $client = @stream_socket_client(
            "ssl://{$host}:{$port}",
            $errno,
            $errstr,
            $timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (! $client) {
            Log::warning("SSL check failed for {$host}: {$errstr}");
            return null;
        }

        $params = stream_context_get_params($client);
        fclose($client);

        if (! isset($params['options']['ssl']['peer_certificate'])) {
            return null;
        }

        $certInfo = openssl_x509_parse($params['options']['ssl']['peer_certificate']);

        return [
            'issuer' => $certInfo['issuer']['O'] ?? $certInfo['issuer']['CN'] ?? 'Unknown',
            'valid_from' => date('Y-m-d', $certInfo['validFrom_time_t']),
            'valid_to' => date('Y-m-d', $certInfo['validTo_time_t']),
        ];
    }
}