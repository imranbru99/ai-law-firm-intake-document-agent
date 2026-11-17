<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LegalDocument extends Model
{
    protected $fillable = [
        'matter_id',
        'uploaded_by',
        'title',
        'slug',
        'document_type',
        'status',
        'storage_path',
        'body',
        'ai_analysis',
        'esign_ready',
    ];

    protected function casts(): array
    {
        return [
            'ai_analysis' => 'array',
            'esign_ready' => 'boolean',
        ];
    }

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function signaturePackets(): HasMany
    {
        return $this->hasMany(SignaturePacket::class);
    }
}