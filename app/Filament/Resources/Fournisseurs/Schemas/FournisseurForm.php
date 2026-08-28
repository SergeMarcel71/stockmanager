<?php

namespace App\Filament\Resources\Fournisseurs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FournisseurForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')
                    ->required(),
                TextInput::make('contact'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('telephone')
                    ->tel(),
                TextInput::make('delai_livraison_jours')
                    ->required()
                    ->numeric()
                    ->default(7),
            ]);
    }
}
