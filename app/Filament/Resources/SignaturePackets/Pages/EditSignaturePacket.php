<?php

namespace App\Filament\Resources\SignaturePackets\Pages;

use App\Filament\Resources\SignaturePackets\SignaturePacketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSignaturePacket extends EditRecord
{
    protected static string $resource = SignaturePacketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
