<?php

namespace App\Filament\Resources\SignaturePackets;

use App\Filament\Resources\SignaturePackets\Pages\CreateSignaturePacket;
use App\Filament\Resources\SignaturePackets\Pages\EditSignaturePacket;
use App\Filament\Resources\SignaturePackets\Pages\ListSignaturePackets;
use App\Filament\Resources\SignaturePackets\Schemas\SignaturePacketForm;
use App\Filament\Resources\SignaturePackets\Tables\SignaturePacketsTable;
use App\Models\SignaturePacket;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SignaturePacketResource extends Resource
{
    protected static ?string $model = SignaturePacket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    protected static string|UnitEnum|null $navigationGroup = 'Documents & E-Sign';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('esign_readiness');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return SignaturePacketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SignaturePacketsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSignaturePackets::route('/'),
            'create' => CreateSignaturePacket::route('/create'),
            'edit' => EditSignaturePacket::route('/{record}/edit'),
        ];
    }
}