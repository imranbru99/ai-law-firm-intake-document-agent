<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConflictCheck extends Model
{
    protected $fillable = [
        'matter_id',
        'client_id',
        'requested_by',
        'reviewed_by',
        'subject_name',
        'adverse_parties',
        'risk_level',
        'risk_score',
        'status',
        'findings',
        'resolution_notes',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'adverse_parties' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}