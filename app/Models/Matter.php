<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matter extends Model
{
    protected $fillable = [
        'matter_number',
        'title',
        'slug',
        'client_id',
        'assigned_attorney_id',
        'created_by',
        'practice_area',
        'status',
        'summary',
        'intake_payload',
        'estimated_value',
        'opened_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'intake_payload' => 'array',
            'estimated_value' => 'decimal:2',
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function assignedAttorney(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_attorney_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function conflictChecks(): HasMany
    {
        return $this->hasMany(ConflictCheck::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LegalDocument::class);
    }

    public function signaturePackets(): HasMany
    {
        return $this->hasMany(SignaturePacket::class);
    }

    public function billingNotes(): HasMany
    {
        return $this->hasMany(BillingNote::class);
    }

    public function portalMessages(): HasMany
    {
        return $this->hasMany(PortalMessage::class);
    }
}