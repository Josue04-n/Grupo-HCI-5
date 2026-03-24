<?php

namespace App\Filament\Resources\Tareas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TareaForm
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
                Textarea::make('escenario')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('resultado_esperado')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('metrica_principal')
                    ->default(null),
                TextInput::make('criterio_exito')
                    ->default(null),
                Textarea::make('guion_texto')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('pregunta_seguimiento')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
