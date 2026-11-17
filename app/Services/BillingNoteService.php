<?php

namespace App\Services;

use App\Models\BillingNote;
use App\Models\Matter;
use App\Models\User;

class BillingNoteService
{
    public function __construct(private readonly ModuleManager $modules)
    {
    }

    public function capture(Matter $matter, User $user, array $data): BillingNote
    {
        if (! $this->modules->enabled('billing_notes')) {
            abort(403, 'Billing Notes module is disabled.');
        }

        return BillingNote::query()->create([
            'matter_id' => $matter->id,
            'user_id' => $user->id,
            'worked_on' => $data['worked_on'] ?? now()->toDateString(),
            'hours' => $data['hours'] ?? 0.1,
            'activity' => $data['activity'] ?? 'intake',
            'narrative' => $data['narrative'],
            'billable' => $data['billable'] ?? true,
            'status' => $data['status'] ?? 'draft',
        ]);
    }
}