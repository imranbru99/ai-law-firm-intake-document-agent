<?php

namespace App\Filament\Widgets;

use App\Models\ConflictCheck;
use App\Models\LegalDocument;
use App\Models\Matter;
use App\Models\SignaturePacket;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LegalStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open Matters', Matter::query()->whereNotIn('status', ['closed', 'declined'])->count())
                ->description('Active intake & open files')
                ->color('primary'),
            Stat::make('Pending Conflicts', ConflictCheck::query()->whereIn('status', ['pending', 'needs_review'])->count())
                ->description('Awaiting review')
                ->color('warning'),
            Stat::make('Documents Ready', LegalDocument::query()->whereIn('status', ['reviewed', 'esign_ready'])->count())
                ->description('AI-assisted drafts')
                ->color('success'),
            Stat::make('E-Sign Queue', SignaturePacket::query()->whereIn('status', ['ready', 'sent'])->count())
                ->description('Packets in flight')
                ->color('info'),
        ];
    }
}