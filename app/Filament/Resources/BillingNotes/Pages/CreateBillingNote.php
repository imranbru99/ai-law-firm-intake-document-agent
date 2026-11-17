<?php

namespace App\Filament\Resources\BillingNotes\Pages;

use App\Filament\Resources\BillingNotes\BillingNoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBillingNote extends CreateRecord
{
    protected static string $resource = BillingNoteResource::class;
}
