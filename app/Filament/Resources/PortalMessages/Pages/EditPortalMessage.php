<?php

namespace App\Filament\Resources\PortalMessages\Pages;

use App\Filament\Resources\PortalMessages\PortalMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPortalMessage extends EditRecord
{
    protected static string $resource = PortalMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
