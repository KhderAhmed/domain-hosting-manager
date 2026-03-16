# Domain & Hosting Manager

[![Laravel](https://img.shields.io/badge/Laravel-12-red)](https://laravel.com/)
[![Vue](https://img.shields.io/badge/Vue-3-brightgreen)](https://vuejs.org/)
[![Inertia.js](https://img.shields.io/badge/Inertia.js-Enabled-blue)](https://inertiajs.com/)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-Installed-lightblue)](https://tailwindcss.com/)

---

## 🎯 Goal
A control panel to manage your domains and hosting in one place:
- Manage all domains from a single dashboard
- Track expiration dates
- Link domains to servers
- Monitor hosting status
- Send automated renewal alerts

---

## 🏗️ Technical Architecture

**Backend:**
- PHP
- Laravel 12
- REST API

**Frontend:**
- Vue 3
- Inertia.js
- TailwindCSS

**Useful Add-ons:**
- Laravel Scheduler for automated tasks
- Laravel Notifications
- Queue system

---

## 📦 Core Modules

### Domains Management
| Field | Description |
|-------|------------|
| domain_name | Domain name |
| registrar | Domain registrar |
| purchase_date | Purchase date |
| expiry_date | Expiration date |
| auto_renew | Auto renewal |
| status | Active / Expired |

### Servers Management
| Field | Description |
|-------|------------|
| server_name | Server name |
| ip_address | IP address |
| provider | Service provider |
| location | Server location |
| status | Online / Offline |

### Domain-Server Linking
| Field | Description |
|-------|------------|
| domain_id | Linked domain |
| server_id | Linked server |
| dns_status | DNS status |
| ssl_status | SSL status |

### Hosting Monitoring
System checks:
- Ping
- DNS
- SSL
- HTTP Status

Example:example.com
Status: Online
HTTP: 200
SSL: Valid
DNS: OK


### Domain Renewal Alerts
Alerts are sent:
- 30 days before expiry
- 15 days before expiry
- 7 days before expiry
- On the expiry day

```php
$schedule->command('domains:check-expiry')->daily();

$domains = Domain::whereDate('expiry_date', '<=', now()->addDays(30))->get();
foreach ($domains as $domain) {
    Notification::send($domain->user, new DomainExpiryNotification($domain));
}
🗄️ Database Design

Domains Table

id, domain_name, registrar, purchase_date, expiry_date, auto_renew, status, created_at

Servers Table

id, server_name, ip_address, provider, location, status, created_at

Domain-Server Table

id, domain_id, server_id, dns_status, ssl_status, created_at

Hosting Accounts Table

id, domain_id, server_id, username, panel, disk_usage, bandwidth_usage, status, created_at

DNS Records Table

id, domain_id, type, name, value, ttl, created_at

SSL Certificates Table

id, domain_id, issuer, valid_from, valid_to, status, created_at

Notifications Table

id, user_id, type, data, read_at, created_at

Activity Logs Table

id, user_id, action, subject_type, subject_id, created_at

🔗 Relationships
User
 └── Team
       ├── Domains
       │      ├── DNS
       │      ├── SSL
       │      └── Hosting
       └── Servers
2️⃣ System Interface (Wireframes)
Dashboard

Total Domains: 120

Expiring Soon: 8

Servers Online: 6

Recent Alerts

[!] example.com expires in 7 days

[!] server-2 offline

Domains Page
Domain	Expiry	Server	Status
example.com	2026-04-01	server-1	Active
Servers Page
Name	IP	Status
server-1	192.168.1.1	Online
Domain Details

Registrar: Namecheap

Expiry: 2026-04-01

SSL: Valid

Server: server-1

DNS Records

Type	Name	Value
A	@	192.168.1.1
CNAME	www	example.com
MX	mail	mail.example.com
3️⃣ Getting Started (Laravel + Vue + Inertia)
# Create Laravel project
composer create-project laravel/laravel domain-manager

# Install Inertia and Vue
composer require inertiajs/inertia-laravel
npm install vue@3 @inertiajs/vue3

app.js

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

createInertiaApp({
  resolve: name => require(`./Pages/${name}.vue`),
  setup({ el, App, props }) {
    createApp({ render: () => h(App, props) }).mount(el)
  },
})

Domain Model

php artisan make:model Domain -mcr

Migration

Schema::create('domains', function (Blueprint $table) {
    $table->id();
    $table->string('domain_name');
    $table->string('registrar')->nullable();
    $table->date('purchase_date')->nullable();
    $table->date('expiry_date');
    $table->boolean('auto_renew')->default(false);
    $table->timestamps();
});

Controller

class DomainController extends Controller
{
    public function index()
    {
        return Inertia::render('Domains/Index', [
            'domains' => Domain::latest()->get()
        ]);
    }
}

Vue Page

<template>
  <div>
    <h1>Domains</h1>
    <table>
      <tr v-for="domain in domains" :key="domain.id">
        <td>{{ domain.domain_name }}</td>
        <td>{{ domain.expiry_date }}</td>
      </tr>
    </table>
  </div>
</template>

<script setup>
defineProps({
  domains: Array
})
</script>

Route

Route::get('/domains', [DomainController::class,'index']);
🔔 Domain Expiry Alerts
php artisan make:command CheckDomainExpiry
$domains = Domain::whereDate('expiry_date', '<=', now()->addDays(30))->get();
foreach ($domains as $domain) {
    Notification::send($domain->user, new DomainExpiryNotification($domain));
}
🚀 Outcome

The system will handle:

✔ Domain management

✔ Server management

✔ SSL monitoring

✔ DNS monitoring

✔ Renewal alerts