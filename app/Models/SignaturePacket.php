<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignaturePacket extends Model
{
    protected $fillable = [
        'matter_id',
        'legal_document_id',
        'name',
        'status',
        'signers',
        'sent_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'signers' => 'array',
            'sent_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(LegalDocument::class, 'legal_document_id');
    }
}