# Domain & Hosting Manager

A multi-tenant domain & hosting management dashboard built with **Laravel 12**, **Vue 3**, and **Inertia.js**.

[![Tests](https://github.com/KhderAhmed/domain-manager/actions/workflows/tests.yml/badge.svg)](https://github.com/KhderAhmed/domain-manager/actions/workflows/tests.yml)
[![Laravel](https://img.shields.io/badge/Laravel-12-red)](https://laravel.com/)
[![Vue](https://img.shields.io/badge/Vue-3-brightgreen)](https://vuejs.org/)
[![Docker](https://img.shields.io/badge/Docker-Ready-blue)](https://www.docker.com/)

---

## What it does

Domain Manager is a SaaS-style dashboard for managing domains, DNS records, SSL certificates, hosting accounts, servers, and uptime monitoring — with **strict per-user data isolation** enforced at the policy layer.

Unlike typical CRUD demos, every resource is scoped to its owner. An authenticated user **cannot** view, edit, or delete another user's data — enforced by Laravel Policies and covered by **45 automated tests**.

---

## Features

### Core

- **Domains** — create, edit, delete, track expiry dates and auto-renewal
- **DNS Records** — A, AAAA, CNAME, MX, TXT, NS, SRV types tied to owned domains
- **SSL Certificates** — track issuer, validity, and days-left with automatic status
- **Hosting Accounts** — link domains to servers with disk/bandwidth tracking
- **Servers** — infrastructure inventory (admin-managed)
- **Activity Logs** — full audit trail, per-user scoped

### Monitoring & Automation

- **Uptime checks** — scheduled HTTP probes with response time and status logging
- **SSL expiry checks** — daily validation of certificate validity
- **Expiry notifications** — 30-day warning window for domain renewals
- **Queue-based jobs** — all checks run asynchronously via `ShouldQueue`

### Security & Access Control

- **Per-user data isolation** — Policies on `Domain`, `DnsRecord`, `SslCertificate`, `HostingAccount`, `Server`, `Monitor`
- **Admin override** — admin users see all data; regular users see only their own
- **Route-model binding validation** — `Rule::exists(...)->where('user_id', ...)` on all cross-resource writes
- **Form Request validation** — FQDN regex, date ordering, TTL bounds

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 8.2, Laravel 12 |
| Frontend | Vue 3, Inertia.js 2, Tailwind CSS |
| Database | MySQL 8 (prod), SQLite (tests) |
| Queue | Database (dev), Redis (prod) |
| Testing | PHPUnit, 45 feature tests |
| Container | Docker, docker-compose (app + nginx + mysql + redis + queue + scheduler) |
| CI | GitHub Actions |

---

## Architecture Highlights

### Multi-tenancy via Policies

Every resource that belongs to a user is protected by a Policy:

```php
class DomainPolicy
{
    private function ownsOrAdmin(User $user, Domain $domain): bool
    {
        return $user->is_admin || $user->id === $domain->user_id;
    }

    public function view(User $user, Domain $domain): bool
    {
        return $this->ownsOrAdmin($user, $domain);
    }
}
```

Controllers call `Gate::authorize('view', $domain)` at the top of every method.

### Cross-resource ownership

`DnsRecord`, `SslCertificate`, and `HostingAccount` don't carry `user_id` directly — ownership is derived through their parent `Domain`. Writes are validated with:

```php
'domain_id' => [
    'required',
    Rule::exists('domains', 'id')->when(
        ! $user->is_admin,
        fn ($q) => $q->where('user_id', $user->id)
    ),
],
```

This prevents a user from attaching DNS records or SSL certs to a domain they don't own.

### Scheduled jobs

```php
Schedule::call(function () {
    Monitor::pluck('id')->each(fn ($id) => CheckDomainUptimeJob::dispatch($id));
})->everyFiveMinutes();

Schedule::call(function () {
    Domain::pluck('id')->each(fn ($id) => CheckSslExpiryJob::dispatch($id));
})->dailyAt('03:00');

Schedule::job(new SendExpiryNotificationsJob)->dailyAt('09:00');
```

---

## Testing

The project has 45 feature tests covering authorization, ownership isolation, and job behavior.

```bash
php artisan test
```

Coverage areas:

| Test Suite | What it verifies |
|------------|------------------|
| `DomainOwnershipTest` | Users cannot view/edit/delete other users' domains |
| `AdminAccessTest` | Admins bypass ownership checks |
| `DnsAccessTest` | DNS ownership via parent domain |
| `SslAccessTest` | SSL ownership via parent domain |
| `HostingAccessTest` | Hosting ownership via parent domain |
| `ServerAccessTest` | Only admins can create/update/delete servers |
| `MonitorAccessTest` | Monitors scoped by domain ownership |
| `ActivityLogAccessTest` | Users see only their own logs |
| `MonitorJobsTest` | Jobs write logs on success/failure/timeout |

---

## Running Locally

### With Docker (recommended)

```bash
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
```

Visit http://localhost:8080. Default admin: `admin@gmail.com` / `password`.

### Without Docker

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
```

### Run tests

```bash
php artisan test
```

---

## Project Structure

```text
app/
├── Http/
│   ├── Controllers/       # Domain, Server, Dns, Ssl, Hosting, Monitor, ActivityLog
│   ├── Middleware/        # EnsureUserIsAdmin
│   └── Requests/          # DomainRequest (FQDN + date validation)
├── Jobs/                  # CheckDomainUptimeJob, CheckSslExpiryJob, SendExpiryNotificationsJob
├── Models/                # Domain, Server, DnsRecord, SslCertificate, Monitor, MonitorLog
├── Policies/              # Domain, Server, DnsRecord, SslCertificate, HostingAccount
└── Services/              # MonitorService (HTTP + SSL checks)

tests/Feature/             # 45 tests across 9 suites
docker/                    # Dockerfile, nginx config, php.ini
.github/workflows/         # CI pipeline
```

---

## Roadmap

- [ ] Real-time monitor dashboard (WebSockets via Reverb)
- [ ] Email notifications for expiring domains (currently logged)
- [ ] DNS propagation checker via public resolvers
- [ ] Team/multi-user access per domain
- [ ] Export reports (PDF/CSV)

---

## License

MIT
