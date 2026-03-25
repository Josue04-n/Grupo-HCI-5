<?php

namespace App\Filament\Resources\Hallazgos\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\PruebaUsabilidad;
use App\Models\CatSeveridad;
use App\Models\CatPrioridad;
use App\Models\CatEstadoHallazgo;

class HallazgoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. PRUEBA: Muestra el nombre de la prueba (JEP o Maquita)
                Select::make('prueba_id')
                    ->label('Plan de Prueba')
                    ->required()
                    ->options(function () {
                        return PruebaUsabilidad::all()->pluck('nombre', 'id');
                    })
                    ->searchable()
                    ->preload(),

                // 2. SEVERIDAD: Baja, Media, Alta, Crítica
                Select::make('severidad_id')
                    ->label('Nivel de Severidad')
                    ->required()
                    ->options(function () {
                        return CatSeveridad::all()->pluck('nombre', 'id');
                    })
                    ->preload(),

                // 3. PRIORIDAD: Baja, Media, Alta
                Select::make('prioridad_id')
                    ->label('Prioridad de Solución')
                    ->required()
                    ->options(function () {
                        return CatPrioridad::all()->pluck('nombre', 'id');
                    })
                    ->preload(),

                // 4. ESTADO: El que acabamos de llenar (Identificado, Solucionado...)
                Select::make('estado_id')
                    ->label('Estado del Hallazgo')
                    ->required()
                    ->options(function () {
                        return CatEstadoHallazgo::all()->pluck('nombre', 'id');
                    })
                    ->preload(),

                // 5. CAMPOS DE TEXTO
                Textarea::make('problema')
                    ->label('Descripción del Problema')
                    ->required()
                    ->placeholder('Ej: El usuario no encuentra el botón de balances.')
                    ->columnSpanFull(),

                Textarea::make('evidencia')
                    ->label('Evidencia / Notas')
                    ->default(null)
                    ->placeholder('Ej: 4 de 6 usuarios fallaron en esta tarea.')
                    ->columnSpanFull(),

                TextInput::make('frecuencia')
                    ->label('Frecuencia (%)')
                    ->placeholder('Ej: 60%')
                    ->default(null),

                Textarea::make('recomendacion')
                    ->label('Recomendación de Mejora')
                    ->required()
                    ->placeholder('Ej: Cambiar el color del botón a uno más llamativo.')
                    ->columnSpanFull(),
            ]);
    }
}