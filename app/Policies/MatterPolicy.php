<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Matter;
use App\Models\User;

class MatterPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role !== UserRole::Client;
    }

    public function view(User $user, Matter $matter): bool
    {
        if ($user->role === UserRole::Client) {
            return $matter->client?->portal_user_id === $user->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, [
            UserRole::SuperAdmin,
            UserRole::Admin,
            UserRole::Manager,
            UserRole::Staff,
            UserRole::Demo,
        ], true);
    }

    public function update(User $user, Matter $matter): bool
    {
        return $this->create($user);
    }

    public function delete(User $user, Matter $matter): bool
    {
        return $user->isAdmin();
    }
}