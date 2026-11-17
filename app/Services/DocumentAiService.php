<?php

namespace App\Services;

use App\Models\LegalDocument;
use App\Models\Matter;
use App\Models\User;
use Illuminate\Support\Str;

class DocumentAiService
{
    public function __construct(private readonly ModuleManager $modules)
    {
    }

    public function draft(Matter $matter, string $documentType, string $prompt, ?User $actor = null): LegalDocument
    {
        if (! $this->modules->enabled('document_ai')) {
            abort(403, 'Document AI module is disabled.');
        }

        $title = Str::headline($documentType).' — '.$matter->matter_number;
        $body = $this->composeDraft($matter, $documentType, $prompt);

        return LegalDocument::query()->create([
            'matter_id' => $matter->id,
            'uploaded_by' => $actor?->id,
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'document_type' => $documentType,
            'status' => 'ai_draft',
            'body' => $body,
            'ai_analysis' => [
                'prompt' => $prompt,
                'clauses' => $this->suggestClauses($documentType),
                'risk_flags' => $this->riskFlags($documentType),
                'confidence' => 0.86,
                'generated_at' => now()->toIso8601String(),
            ],
            'esign_ready' => false,
        ]);
    }

    public function analyze(LegalDocument $document): LegalDocument
    {
        $analysis = [
            'word_count' => str_word_count(strip_tags((string) $document->body)),
            'clauses' => $this->suggestClauses($document->document_type),
            'risk_flags' => $this->riskFlags($document->document_type),
            'summary' => Str::limit(strip_tags((string) $document->body), 240),
            'analyzed_at' => now()->toIso8601String(),
        ];

        $document->update([
            'ai_analysis' => array_merge($document->ai_analysis ?? [], $analysis),
            'status' => 'reviewed',
        ]);

        return $document->fresh();
    }

    private function composeDraft(Matter $matter, string $type, string $prompt): string
    {
        return <<<TXT
DRAFT {$type} — {$matter->title}

Client: {$matter->client->name}
Practice area: {$matter->practice_area}
Matter: {$matter->matter_number}

Instructions: {$prompt}

1. Parties and recitals
2. Scope of engagement / obligations
3. Confidentiality and privilege acknowledgements
4. Governing law and venue
5. Signature blocks

[AI-assisted draft — attorney review required before client delivery]
TXT;
    }

    private function suggestClauses(string $type): array
    {
        return match ($type) {
            'engagement_letter' => ['scope', 'fees', 'termination', 'conflicts disclosure'],
            'nda' => ['definition of confidential info', 'term', 'residuals', 'remedies'],
            'msa' => ['services', 'SLAs', 'indemnity', 'limitation of liability'],
            default => ['definitions', 'obligations', 'termination', 'governing law'],
        };
    }

    private function riskFlags(string $type): array
    {
        return match ($type) {
            'msa' => ['unlimited indemnity', 'auto-renewal'],
            'nda' => ['perpetual term'],
            default => ['missing governing law'],
        };
    }
}