<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('check:domains', function () {
    // تشغيل الكوماند الأصلي
    Artisan::call('app:check-domain-expiry');

 
    $this->info(Artisan::output());
})->describe('Check all domains that will expire within 30 days');

Artisan::command('check-ssl', function () {
    // تشغيل الكوماند الأصلي
    Artisan::call('app:check-domain-expiry');

    // طباعة النتائج في الـ console
    $this->info(Artisan::output());
})->describe('Check all domains that will expire within 30 days');


Artisan::command('check-uptime', function () {
    // تشغيل الكوماند الأصلي
    Artisan::call('app:check-domain-expiry');

    // طباعة النتائج في الـ console
    $this->info(Artisan::output());
})->describe('Check if domains are online or down');
//php artisan app:check-uptime