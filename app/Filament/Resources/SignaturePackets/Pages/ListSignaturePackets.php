<?php

namespace App\Filament\Resources\SignaturePackets\Pages;

use App\Filament\Resources\SignaturePackets\SignaturePacketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSignaturePackets extends ListRecords
{
    protected static string $resource = SignaturePacketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
