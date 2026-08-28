<?php

namespace App\Filament\Resources\MouvementStocks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MouvementStockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('produit_id')
                    ->relationship('produit', 'id')
                    ->required(),
                Select::make('depot_id')
                    ->relationship('depot', 'id'),
                Select::make('utilisateur_id')
                    ->relationship('utilisateur', 'name')
                    ->required(),
                Select::make('type')
                    ->options([
            'entree' => 'Entree',
            'sortie' => 'Sortie',
            'transfert' => 'Transfert',
            'ajustement' => 'Ajustement',
        ])
                    ->required(),
                TextInput::make('quantite')
                    ->required()
                    ->numeric(),
                TextInput::make('motif'),
                DateTimePicker::make('date_mouvement')
                    ->required(),
            ]);
    }
}
