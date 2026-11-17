<?php

namespace App\Services;

use App\Models\Client;
use App\Models\ConflictCheck;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ConflictCheckService
{
    public function __construct(private readonly ModuleManager $modules)
    {
    }

    public function run(Matter $matter, array $adverseParties, ?User $requester = null): ConflictCheck
    {
        if (! $this->modules->enabled('conflict_check')) {
            abort(403, 'Conflict Check module is disabled.');
        }

        $matches = $this->findPotentialConflicts($matter->client, $adverseParties);
        $score = min(100, $matches->count() * 25 + (count($adverseParties) > 3 ? 10 : 0));
        $risk = $this->scoreToRisk($score);

        return ConflictCheck::query()->create([
            'matter_id' => $matter->id,
            'client_id' => $matter->client_id,
            'requested_by' => $requester?->id,
            'subject_name' => $matter->client->name,
            'adverse_parties' => $adverseParties,
            'risk_level' => $risk,
            'risk_score' => $score,
            'status' => $risk === 'blocked' ? 'blocked' : ($score > 0 ? 'needs_review' : 'clear'),
            'findings' => $matches->isEmpty()
                ? 'No adverse party overlap detected in current client roster.'
                : 'Potential overlaps: '.$matches->pluck('name')->implode(', '),
        ]);
    }

    public function findPotentialConflicts(?Client $client, array $adverseParties): Collection
    {
        $needles = collect($adverseParties)
            ->merge($client?->aliases ?? [])
            ->filter()
            ->map(fn ($n) => Str::lower(trim($n)))
            ->unique()
            ->values();

        if ($needles->isEmpty()) {
            return collect();
        }

        return Client::query()
            ->when($client, fn ($q) => $q->where('id', '!=', $client->id))
            ->get()
            ->filter(function (Client $existing) use ($needles) {
                $haystack = collect([$existing->name, $existing->company])
                    ->merge($existing->aliases ?? [])
                    ->filter()
                    ->map(fn ($n) => Str::lower($n));

                return $needles->contains(fn ($needle) => $haystack->contains(fn ($h) => Str::contains($h, $needle) || Str::contains($needle, $h)));
            })
            ->values();
    }

    private function scoreToRisk(int $score): string
    {
        return match (true) {
            $score >= 75 => 'blocked',
            $score >= 50 => 'high',
            $score >= 25 => 'medium',
            $score > 0 => 'low',
            default => 'clear',
        };
    }
}