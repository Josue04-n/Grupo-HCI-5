<?php

namespace App\Filament\Resources\Hallazgos\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HallazgoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('prueba_id')
                    ->required()
                    ->numeric(),
                TextInput::make('severidad_id')
                    ->required()
                    ->numeric(),
                TextInput::make('prioridad_id')
                    ->required()
                    ->numeric(),
                TextInput::make('estado_id')
                    ->required()
                    ->numeric(),
                Textarea::make('problema')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('evidencia')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('frecuencia')
                    ->default(null),
                Textarea::make('recomendacion')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
