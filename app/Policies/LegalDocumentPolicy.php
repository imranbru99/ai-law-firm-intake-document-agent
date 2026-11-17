<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\LegalDocument;
use App\Models\User;

class LegalDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, LegalDocument $legalDocument): bool
    {
        if ($user->role === UserRole::Client) {
            return $legalDocument->matter?->client?->portal_user_id === $user->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        return $user->role !== UserRole::Client;
    }

    public function update(User $user, LegalDocument $legalDocument): bool
    {
        return $user->role !== UserRole::Client;
    }

    public function delete(User $user, LegalDocument $legalDocument): bool
    {
        return $user->isAdmin();
    }
}