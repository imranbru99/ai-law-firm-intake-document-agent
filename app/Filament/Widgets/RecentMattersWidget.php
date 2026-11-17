<?php

namespace App\Filament\Widgets;

use App\Models\Matter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentMattersWidget extends TableWidget
{
    protected static ?string $heading = 'Recent Matters';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Matter::query()->latest()->limit(8))
            ->columns([
                TextColumn::make('matter_number')->label('Matter ID')->searchable(),
                TextColumn::make('client.name')->label('Client'),
                TextColumn::make('practice_area')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('assignedAttorney.name')->label('Attorney')->placeholder('Unassigned'),
            ])
            ->paginated(false);
    }
}