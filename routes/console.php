<?php

use App\Jobs\CheckDomainUptimeJob;
use App\Jobs\CheckSslExpiryJob;
use App\Jobs\SendExpiryNotificationsJob;
use App\Models\Domain;
use App\Models\Monitor;
use Illuminate\Support\Facades\Schedule;

// فحص الـ uptime كل 5 دقايق للمونيتورز
Schedule::call(function () {
    Monitor::pluck('id')->each(fn ($id) => CheckDomainUptimeJob::dispatch($id));
})->everyFiveMinutes()->name('uptime-check');

// فحص SSL يومياً الساعة 3 صباحاً
Schedule::call(function () {
    Domain::pluck('id')->each(fn ($id) => CheckSslExpiryJob::dispatch($id));
})->dailyAt('03:00')->name('ssl-check');

// إشعارات الانتهاء يومياً الساعة 9 صباحاً
Schedule::job(new SendExpiryNotificationsJob)->dailyAt('09:00')->name('expiry-notifications');