<?php

namespace App\Policies;

use App\Models\Server;
use App\Models\User;

class ServerPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // الكل بيشوف السيرفرات
    }

    public function view(User $user, Server $server): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Server $server): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Server $server): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, Server $server): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Server $server): bool
    {
        return $user->is_admin;
    }
}