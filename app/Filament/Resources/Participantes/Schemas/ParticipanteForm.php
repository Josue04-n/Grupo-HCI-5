<?php

namespace App\Filament\Resources\Participantes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ParticipanteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('prueba_id')
                    ->required()
                    ->numeric(),
                TextInput::make('codigo')
                    ->required(),
                TextInput::make('perfil')
                    ->required(),
                TextInput::make('experiencia')
                    ->default(null),
                TextInput::make('edad')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
