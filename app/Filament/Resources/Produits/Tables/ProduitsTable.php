<?php

namespace App\Filament\Resources\Produits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProduitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('categorie.nom')
                    ->label('Catégorie')
                    ->searchable(),
                TextColumn::make('fournisseur.nom')
                    ->label('Fournisseur')
                    ->searchable(),
                TextColumn::make('prix_unitaire')
                    ->label('Prix')
                    ->numeric()
                    ->sortable()
                    ->suffix(' €'),
                TextColumn::make('quantite_stock')
                    ->label('Stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('statut')
                    ->label('Statut')
                    ->state(fn ($record) => $record->estEnAlerte() ? 'Alerte' : 'OK')
                    ->badge()
                    ->color(fn ($record) => $record->estEnAlerte() ? 'danger' : 'success'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
