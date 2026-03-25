<?php

namespace App\Filament\Resources\Observacions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Sesion;
use App\Models\CatSeveridad;

class ObservacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. SESIÓN: Ahora muestra Participante y Tarea en lugar de ID
                Select::make('sesion_id')
            ->label('Sesión del Participante')
            ->required()
            ->options(function () {
                // Cargamos las sesiones con sus relaciones para traer el Código real
                return Sesion::with(['participante', 'tarea', 'aplicativo'])->get()->mapWithKeys(function ($sesion) {
                    // Accedemos al código del participante (P1, P2...) y no a su ID numérico
                    $participante = $sesion->participante ? $sesion->participante->codigo : "S/N";
                    $tarea = $sesion->tarea ? $sesion->tarea->codigo : "T/N";
                    $aplicativo = $sesion->aplicativo ? $sesion->aplicativo->nombre : "App";

                    return [
                        $sesion->id => "Sesión #{$sesion->id} | {$participante} | {$tarea} | {$aplicativo}"
                    ];
                });
            })
            ->searchable()
            ->preload(),

                // 2. SEVERIDAD: Ahora muestra los nombres (Alta, Media, Baja)
                Select::make('severidad_id')
                    ->label('Nivel de Severidad')
                    ->options(function() {
                        return CatSeveridad::all()->pluck('nombre', 'id');
                    })
                    ->required()
                    ->searchable(),

                // 3. ÉXITO (Ya estaba bien como Select)
                Select::make('exito')
                    ->label('Estado de Finalización')
                    ->options([
                        'Sí, sin ayuda' => 'Sí, sin ayuda',
                        'Sí, con poca ayuda' => 'Sí, con poca ayuda',
                        'Sí, con mucha ayuda' => 'Sí, con mucha ayuda',
                        'No completó' => 'No completó',
                    ])
                    ->default(null),

                TextInput::make('eficacia')
                    ->numeric()
                    ->label('Eficacia (0-3)')
                    ->default(null),

                TextInput::make('eficiencia')
                    ->numeric()
                    ->label('Eficiencia (1-5)')
                    ->default(null),

                TextInput::make('satisfaccion')
                    ->label('Satisfacción (1-5)')
                    ->numeric()
                    ->default(null),

                TextInput::make('tiempo_seg')
                    ->label('Tiempo (segundos)')
                    ->numeric()
                    ->default(null),

                TextInput::make('errores')
                    ->label('Número de errores')
                    ->required()
                    ->numeric()
                    ->default(0),

                Textarea::make('comentarios')
                    ->default(null)
                    ->columnSpanFull(),

                Textarea::make('problema_detectado')
                    ->default(null)
                    ->columnSpanFull(),

                Textarea::make('mejora_propuesta')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}