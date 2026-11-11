<?php

namespace App\Policies;

use App\Models\SslCertificate;
use App\Models\User;

class SslCertificatePolicy
{
    private function ownsViaDomain(User $user, SslCertificate $ssl): bool
    {
        return $user->is_admin || $ssl->domain?->user_id === $user->id;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SslCertificate $ssl): bool
    {
        return $this->ownsViaDomain($user, $ssl);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SslCertificate $ssl): bool
    {
        return $this->ownsViaDomain($user, $ssl);
    }

    public function delete(User $user, SslCertificate $ssl): bool
    {
        return $this->ownsViaDomain($user, $ssl);
    }
}