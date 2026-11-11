<?php

namespace App\Policies;

use App\Models\DnsRecord;
use App\Models\User;

class DnsRecordPolicy
{
    private function ownsViaDomain(User $user, DnsRecord $dns): bool
    {
        return $user->is_admin || $dns->domain?->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, DnsRecord $dns): bool
    {
        return $this->ownsViaDomain($user, $dns);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, DnsRecord $dns): bool
    {
        return $this->ownsViaDomain($user, $dns);
    }

    public function delete(User $user, DnsRecord $dns): bool
    {
        return $this->ownsViaDomain($user, $dns);
    }
}