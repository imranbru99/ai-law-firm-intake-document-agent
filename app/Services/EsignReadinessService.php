<?php

namespace App\Services;

use App\Models\LegalDocument;
use App\Models\SignaturePacket;
use Illuminate\Support\Arr;

class EsignReadinessService
{
    public function __construct(private readonly ModuleManager $modules)
    {
    }

    public function prepare(LegalDocument $document, array $signers): SignaturePacket
    {
        if (! $this->modules->enabled('esign_readiness')) {
            abort(403, 'E-Sign Readiness module is disabled.');
        }

        $normalized = collect($signers)->map(function ($signer, $index) {
            return [
                'order' => $index + 1,
                'name' => Arr::get($signer, 'name'),
                'email' => Arr::get($signer, 'email'),
                'role' => Arr::get($signer, 'role', 'signer'),
                'status' => 'pending',
            ];
        })->values()->all();

        $document->update([
            'esign_ready' => true,
            'status' => 'esign_ready',
        ]);

        return SignaturePacket::query()->create([
            'matter_id' => $document->matter_id,
            'legal_document_id' => $document->id,
            'name' => 'Packet: '.$document->title,
            'status' => 'ready',
            'signers' => $normalized,
        ]);
    }

    public function markSent(SignaturePacket $packet): SignaturePacket
    {
        $packet->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return $packet->fresh();
    }
}