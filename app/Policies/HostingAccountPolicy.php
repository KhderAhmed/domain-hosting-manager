<?php

namespace App\Policies;

use App\Models\HostingAccount;
use App\Models\User;

class HostingAccountPolicy
{
    private function ownsViaDomain(User $user, HostingAccount $hosting): bool
    {
        return $user->is_admin || $hosting->domain?->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, HostingAccount $hosting): bool
    {
        return $this->ownsViaDomain($user, $hosting);
    }

    public function create(User $user): bool
    {
        return true; // التحقق الفعلي من domain_id في الكنترولر
    }

    public function update(User $user, HostingAccount $hosting): bool
    {
        return $this->ownsViaDomain($user, $hosting);
    }

    public function delete(User $user, HostingAccount $hosting): bool
    {
        return $this->ownsViaDomain($user, $hosting);
    }
}