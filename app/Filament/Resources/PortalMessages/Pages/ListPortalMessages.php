<?php

namespace App\Filament\Resources\PortalMessages\Pages;

use App\Filament\Resources\PortalMessages\PortalMessageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPortalMessages extends ListRecords
{
    protected static string $resource = PortalMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
