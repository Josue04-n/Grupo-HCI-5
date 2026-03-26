<?php

namespace App\Filament\Resources\Participantes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
// --- IMPORTANTE: Añadimos la regla Unique ---
use Illuminate\Validation\Rules\Unique;

class ParticipanteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('prueba_id')
                    ->label('Plan de Prueba')
                    ->relationship('prueba', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                TextInput::make('codigo')
                    ->label('Código')
                    ->placeholder('Ej: P1')
                    ->required()
                    // --- LA REGLA DE PREVENCIÓN DE ERRORES (UX) ---
                    ->unique(
                        table: 'participantes',
                        ignoreRecord: true,
                        // Verificamos que no se repita el código dentro del mismo Plan de Prueba
                        modifyRuleUsing: function (Unique $rule, $get) {
                            return $rule->where('prueba_id', $get('prueba_id'));
                        }
                    )
                    ->validationMessages([
                        'unique' => 'Error: Ya existe un participante con este código en el Plan de Prueba seleccionado.',
                    ]),
                    // ----------------------------------------------

                TextInput::make('perfil')
                    ->label('Perfil')
                    ->placeholder('Ej: Usuario externo')
                    ->required(),

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