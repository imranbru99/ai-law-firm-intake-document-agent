<?php

namespace App\Filament\Resources\BillingNotes\Pages;

use App\Filament\Resources\BillingNotes\BillingNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBillingNote extends EditRecord
{
    protected static string $resource = BillingNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
