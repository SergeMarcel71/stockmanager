<?php

namespace App\Filament\Resources\Depots\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DepotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')
                    ->required(),
                TextInput::make('adresse'),
            ]);
    }
}
