<?php

namespace App\Filament\Resources\ConflictChecks;

use App\Filament\Resources\ConflictChecks\Pages\CreateConflictCheck;
use App\Filament\Resources\ConflictChecks\Pages\EditConflictCheck;
use App\Filament\Resources\ConflictChecks\Pages\ListConflictChecks;
use App\Filament\Resources\ConflictChecks\Schemas\ConflictCheckForm;
use App\Filament\Resources\ConflictChecks\Tables\ConflictChecksTable;
use App\Models\ConflictCheck;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConflictCheckResource extends Resource
{
    protected static ?string $model = ConflictCheck::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Intake & Matters';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('conflict_check');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return ConflictCheckForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConflictChecksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConflictChecks::route('/'),
            'create' => CreateConflictCheck::route('/create'),
            'edit' => EditConflictCheck::route('/{record}/edit'),
        ];
    }
}