<?php

namespace App\Filament\Resources\PortalMessages;

use App\Filament\Resources\PortalMessages\Pages\CreatePortalMessage;
use App\Filament\Resources\PortalMessages\Pages\EditPortalMessage;
use App\Filament\Resources\PortalMessages\Pages\ListPortalMessages;
use App\Filament\Resources\PortalMessages\Schemas\PortalMessageForm;
use App\Filament\Resources\PortalMessages\Tables\PortalMessagesTable;
use App\Models\PortalMessage;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PortalMessageResource extends Resource
{
    protected static ?string $model = PortalMessage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|UnitEnum|null $navigationGroup = 'Client Portal';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('client_portal');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return PortalMessageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PortalMessagesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPortalMessages::route('/'),
            'create' => CreatePortalMessage::route('/create'),
            'edit' => EditPortalMessage::route('/{record}/edit'),
        ];
    }
}