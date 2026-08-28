<?php

namespace App\Filament\Resources\Produits\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProduitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('categorie_id')
                    ->label('Catégorie')
                    ->relationship('categorie', 'nom')
                    ->searchable()
                    ->preload(),
                Select::make('fournisseur_id')
                    ->label('Fournisseur')
                    ->relationship('fournisseur', 'nom')
                    ->searchable()
                    ->preload(),
                TextInput::make('nom')
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('prix_unitaire')
                    ->label('Prix unitaire')
                    ->required()
                    ->numeric()
                    ->prefix('€'),
                TextInput::make('quantite_stock')
                    ->label('Quantité en stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('seuil_alerte')
                    ->label("Seuil d'alerte")
                    ->required()
                    ->numeric()
                    ->default(5),
            ]);
    }
}
