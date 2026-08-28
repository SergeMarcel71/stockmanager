<?php

namespace App\Filament\Resources\MouvementStocks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MouvementStockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('produit.id')
                    ->label('Produit'),
                TextEntry::make('depot.id')
                    ->label('Depot')
                    ->placeholder('-'),
                TextEntry::make('utilisateur.name')
                    ->label('Utilisateur'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('quantite')
                    ->numeric(),
                TextEntry::make('motif')
                    ->placeholder('-'),
                TextEntry::make('date_mouvement')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
