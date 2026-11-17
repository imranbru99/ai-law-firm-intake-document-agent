<?php

namespace App\Filament\Resources\BillingNotes\Pages;

use App\Filament\Resources\BillingNotes\BillingNoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBillingNotes extends ListRecords
{
    protected static string $resource = BillingNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
