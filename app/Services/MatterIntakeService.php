<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Str;

class MatterIntakeService
{
    public function __construct(private readonly ModuleManager $modules)
    {
    }

    public function intake(array $data, ?User $actor = null): Matter
    {
        if (! $this->modules->enabled('matter_intake')) {
            abort(403, 'Matter Intake module is disabled.');
        }

        $client = Client::query()->firstOrCreate(
            ['email' => $data['client_email'] ?? null],
            [
                'name' => $data['client_name'],
                'slug' => Str::slug($data['client_name']).'-'.Str::random(4),
                'phone' => $data['client_phone'] ?? null,
                'company' => $data['client_company'] ?? null,
                'type' => $data['client_type'] ?? 'individual',
                'aliases' => $data['aliases'] ?? [],
            ]
        );

        $title = $data['title'] ?? ($client->name.' — '.($data['practice_area'] ?? 'matter'));

        return Matter::query()->create([
            'matter_number' => $this->nextMatterNumber(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'client_id' => $client->id,
            'assigned_attorney_id' => $data['assigned_attorney_id'] ?? null,
            'created_by' => $actor?->id,
            'practice_area' => $data['practice_area'] ?? 'other',
            'status' => 'conflict_review',
            'summary' => $data['summary'] ?? null,
            'intake_payload' => $data,
            'estimated_value' => $data['estimated_value'] ?? null,
            'opened_at' => now(),
        ]);
    }

    public function nextMatterNumber(): string
    {
        $seq = Matter::query()->count() + 1;

        return sprintf('MAT-%s-%04d', now()->format('Y'), $seq);
    }
}