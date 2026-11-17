<?php

namespace App\Filament\Resources\ConflictChecks\Pages;

use App\Filament\Resources\ConflictChecks\ConflictCheckResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConflictCheck extends CreateRecord
{
    protected static string $resource = ConflictCheckResource::class;
}
