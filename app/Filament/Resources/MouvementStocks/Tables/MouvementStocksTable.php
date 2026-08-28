<?php

namespace App\Filament\Resources\MouvementStocks\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MouvementStocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('produit.nom')
                    ->label('Produit')
                    ->searchable(),
                TextColumn::make('depot.nom')
                    ->label('Dépôt')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('utilisateur.name')
                    ->label('Utilisateur')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'entree' => 'success',
                        'sortie' => 'danger',
                        'ajustement' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('quantite')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('motif')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('date_mouvement')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('date_mouvement', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
