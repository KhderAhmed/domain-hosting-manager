<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\DnsController;
use App\Http\Controllers\SslController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\HostingAccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\Client\LoginController;
use App\Http\Controllers\Client\RegisterController;
// الصفحة الرئيسية (Welcome Page)
Route::get('/', function () {
    return Inertia::render('Welcome');
});
Route::get('/doc', function () {
    return Inertia::render('Docs');
});

Route::middleware('client')->group(function(){

Route::get('/client/dashboard', function(){

return Inertia::render('Client/Dashboard');

});

});

Route::prefix('client')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin']);
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegister']);
    Route::post('/register', [RegisterController::class, 'register']);

    Route::post('/logout', [LoginController::class, 'logout']);
});

// --------------------
// Auth Routes
// --------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');




    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
});

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// --------------------
// Protected Routes (Dashboard + Resources)
// --------------------
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Domains
    Route::prefix('domains')->name('domains.')->group(function () {
        Route::get('/', [DomainController::class, 'index'])->name('index');
        Route::get('/create', [DomainController::class, 'create'])->name('create');
        Route::post('/', [DomainController::class, 'store'])->name('store');
        Route::get('/{domain}', [DomainController::class, 'show'])->name('show');
        Route::get('/{domain}/edit', [DomainController::class, 'edit'])->name('edit');
        Route::patch('/{domain}', [DomainController::class, 'update'])->name('update');
        Route::delete('/{domain}', [DomainController::class, 'destroy'])->name('destroy');
    });

    // Servers
    Route::prefix('servers')->name('servers.')->group(function () {
        Route::get('/', [ServerController::class, 'index'])->name('index');
        Route::get('/create', [ServerController::class, 'create'])->name('create');
        Route::post('/', [ServerController::class, 'store'])->name('store');
        Route::get('/{server}', [ServerController::class, 'show'])->name('show');
        Route::get('/{server}/edit', [ServerController::class, 'edit'])->name('edit');
        Route::patch('/{server}', [ServerController::class, 'update'])->name('update');
        Route::delete('/{server}', [ServerController::class, 'destroy'])->name('destroy');
        Route::get('/{server}/usage', [ServerController::class, 'usage'])->name('usage');
    });

    // DNS
    Route::prefix('dns')->name('dns.')->group(function () {
        Route::get('/', [DnsController::class, 'index'])->name('index');
        Route::get('/create', [DnsController::class, 'create'])->name('create');
        Route::post('/', [DnsController::class, 'store'])->name('store');
        Route::get('/{dns}/edit', [DnsController::class, 'edit'])->name('edit');
        Route::patch('/{dns}', [DnsController::class, 'update'])->name('update');
        Route::delete('/{dns}', [DnsController::class, 'destroy'])->name('destroy');
    });

    // SSL
    Route::prefix('ssl')->name('ssl.')->group(function () {
        Route::get('/', [SslController::class, 'index'])->name('index');
        Route::get('/create', [SslController::class, 'create'])->name('create');
        Route::post('/', [SslController::class, 'store'])->name('store');
        Route::get('/{ssl}/edit', [SslController::class, 'edit'])->name('edit');
        Route::patch('/{ssl}', [SslController::class, 'update'])->name('update');
        Route::delete('/{ssl}', [SslController::class, 'destroy'])->name('destroy');
    });

    // Hosting Accounts
    Route::prefix('hosting')->name('hosting.')->group(function () {
        Route::get('/', [HostingAccountController::class, 'index'])->name('index');
        Route::get('/create', [HostingAccountController::class, 'create'])->name('create');
        Route::post('/', [HostingAccountController::class, 'store'])->name('store');
        Route::get('/{hosting}/edit', [HostingAccountController::class, 'edit'])->name('edit');
        Route::patch('/{hosting}', [HostingAccountController::class, 'update'])->name('update');
        Route::delete('/{hosting}', [HostingAccountController::class, 'destroy'])->name('destroy');
    });

    // Monitoring
    Route::get('/monitor', [MonitorController::class, 'index'])->name('monitor.index');

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
