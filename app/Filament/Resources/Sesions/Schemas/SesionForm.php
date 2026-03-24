<?php

namespace App\Filament\Resources\Sesions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SesionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('prueba_id')
                    ->required()
                    ->numeric(),
                TextInput::make('participante_id')
                    ->required()
                    ->numeric(),
                TextInput::make('tarea_id')
                    ->required()
                    ->numeric(),
                TextInput::make('aplicativo_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('fecha_sesion'),
                TextInput::make('moderador')
                    ->default(null),
            ]);
    }
}
