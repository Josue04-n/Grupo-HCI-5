<?php

namespace App\Filament\Resources\Participantes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ParticipanteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Selección de la prueba por nombre en lugar de ID manual
                Select::make('prueba_id')
                    ->label('Plan de Prueba')
                    ->relationship('prueba', 'nombre') // 'prueba' es la relación en tu modelo
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(), // Ocupa todo el ancho para mejor lectura

                // 2. Identificación del participante (P1, P2, etc.)
                TextInput::make('codigo')
                    ->label('Código')
                    ->placeholder('Ej: P1')
                    ->required(),

                // 3. Perfil del usuario (Externo, Interno, etc.)
                TextInput::make('perfil')
                    ->label('Perfil')
                    ->placeholder('Ej: Usuario externo')
                    ->required(),

                // 4. Experiencia y Edad
                TextInput::make('experiencia')
                    ->label('Experiencia previa')
                    ->placeholder('Ej: Sin experiencia')
                    ->default(null),

                TextInput::make('edad')
                    ->label('Edad')
                    ->numeric()
                    ->minValue(10)
                    ->maxValue(99)
                    ->default(null),
            ]);
    }
}