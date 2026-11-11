<?php

namespace App\Policies;

use App\Models\Domain;
use App\Models\User;

class DomainPolicy
{
    /**
     * الأدمن بيشوف كل شي، المستخدم العادي بيشوف بس دوميناته.
     */
    private function ownsOrAdmin(User $user, Domain $domain): bool
    {
        return $user->is_admin || $user->id === $domain->user_id;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Domain $domain): bool
    {
        return $this->ownsOrAdmin($user, $domain);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Domain $domain): bool
    {
        return $this->ownsOrAdmin($user, $domain);
    }

    public function delete(User $user, Domain $domain): bool
    {
        return $this->ownsOrAdmin($user, $domain);
    }

    public function restore(User $user, Domain $domain): bool
    {
        return $this->ownsOrAdmin($user, $domain);
    }

    public function forceDelete(User $user, Domain $domain): bool
    {
        return $user->is_admin;
    }
}