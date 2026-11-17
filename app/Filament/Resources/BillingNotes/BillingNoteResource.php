<?php

namespace App\Filament\Resources\BillingNotes;

use App\Filament\Resources\BillingNotes\Pages\CreateBillingNote;
use App\Filament\Resources\BillingNotes\Pages\EditBillingNote;
use App\Filament\Resources\BillingNotes\Pages\ListBillingNotes;
use App\Filament\Resources\BillingNotes\Schemas\BillingNoteForm;
use App\Filament\Resources\BillingNotes\Tables\BillingNotesTable;
use App\Models\BillingNote;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BillingNoteResource extends Resource
{
    protected static ?string $model = BillingNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static string|UnitEnum|null $navigationGroup = 'Firm Operations';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('billing_notes');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return BillingNoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BillingNotesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBillingNotes::route('/'),
            'create' => CreateBillingNote::route('/create'),
            'edit' => EditBillingNote::route('/{record}/edit'),
        ];
    }
}