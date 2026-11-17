<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'company',
        'type',
        'address',
        'aliases',
        'portal_user_id',
    ];

    protected function casts(): array
    {
        return [
            'aliases' => 'array',
        ];
    }

    public function portalUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'portal_user_id');
    }

    public function matters(): HasMany
    {
        return $this->hasMany(Matter::class);
    }

    public function conflictChecks(): HasMany
    {
        return $this->hasMany(ConflictCheck::class);
    }

    public function portalMessages(): HasMany
    {
        return $this->hasMany(PortalMessage::class);
    }
}