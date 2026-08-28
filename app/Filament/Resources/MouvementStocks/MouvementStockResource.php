<?php

namespace App\Filament\Resources\MouvementStocks;

use App\Filament\Resources\MouvementStocks\Pages\ListMouvementStocks;
use App\Filament\Resources\MouvementStocks\Pages\ViewMouvementStock;
use App\Filament\Resources\MouvementStocks\Schemas\MouvementStockInfolist;
use App\Filament\Resources\MouvementStocks\Tables\MouvementStocksTable;
use App\Models\MouvementStock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MouvementStockResource extends Resource
{
    protected static ?string $model = MouvementStock::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // Un mouvement de stock est immuable (règle de gestion depuis la v0.2) :
    // on bloque explicitement la création, la modification et la suppression depuis le panel admin.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return MouvementStockInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MouvementStocksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMouvementStocks::route('/'),
            'view' => ViewMouvementStock::route('/{record}'),
        ];
    }
}
