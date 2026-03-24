<?php

namespace App\Filament\Resources\Tareas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TareaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Selección del Plan de Prueba (Relación)
                Select::make('prueba_id')
                    ->label('Plan de Prueba')
                    ->relationship('prueba', 'nombre')
                    ->required()
                    ->searchable()
                    ->preload(),

                // 2. Nombre de la tarea (AHORA COMO TEXTO)
                TextInput::make('nombre')
                    ->label('Nombre de la Tarea')
                    ->placeholder('Ej: Simulador de Crédito')
                    ->required() // Ya no es numérico, ahora permite letras
                    ->maxLength(255),

                // 3. Código (T1, T2, etc.)
                TextInput::make('codigo')
                    ->label('Código')
                    ->placeholder('Ej: T1')
                    ->required(),

                // 4. Escenario y Resultado (Textarea para textos largos)
                Textarea::make('escenario')
                    ->label('Escenario / Tarea para el usuario')
                    ->required()
                    ->columnSpanFull(),

                Textarea::make('resultado_esperado')
                    ->label('Resultado esperado')
                    ->columnSpanFull(),

                // 5. Métricas y Criterios
                TextInput::make('metrica_principal')
                    ->label('Métrica Principal')
                    ->placeholder('Ej: Tiempo y Errores'),

                TextInput::make('criterio_exito')
                    ->label('Criterio de Éxito')
                    ->placeholder('Ej: Menos de 60 segundos'),

                // 6. Guion y Seguimiento
                Textarea::make('guion_texto')
                    ->label('Guion para el moderador')
                    ->columnSpanFull(),

                Textarea::make('pregunta_seguimiento')
                    ->label('Pregunta de cierre')
                    ->columnSpanFull(),
            ]);
    }
}