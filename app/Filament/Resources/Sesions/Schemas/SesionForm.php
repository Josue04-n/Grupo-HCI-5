<?php

namespace App\Filament\Resources\Sesions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Unique;

class SesionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('prueba_id')
                    ->label('Plan de Prueba')
                    ->relationship('prueba', 'nombre')
                    ->required()
                    ->live() 
                    ->preload(),

                Select::make('participante_id')
                    ->label('Participante')
                    ->relationship(
                        name: 'participante', 
                        titleAttribute: 'codigo',
                        // CORRECCIÓN: Quitamos el "Get" antes de "$get"
                        modifyQueryUsing: fn (Builder $query, $get) => 
                            $query->where('prueba_id', $get('prueba_id'))
                    )
                    ->required()
                    ->searchable()
                    ->preload()
                    // --- LA REGLA DE PREVENCIÓN DE ERRORES (UX) ---
                    ->unique(
                        table: 'sesiones',
                        ignoreRecord: true,
                        // CORRECCIÓN: Quitamos el "Get" antes de "$get"
                        modifyRuleUsing: function (Unique $rule, $get) {
                            return $rule
                                ->where('tarea_id', $get('tarea_id'))
                                ->where('aplicativo_id', $get('aplicativo_id'));
                        }
                    )
                    ->validationMessages([
                        'unique' => 'Error: Este participante ya fue evaluado en esta Tarea y Aplicativo.',
                    ]),
                    // ----------------------------------------------

                Select::make('tarea_id')
                    ->label('Tarea a evaluar')
                    ->relationship(
                        name: 'tarea', 
                        titleAttribute: 'codigo',
                        // CORRECCIÓN: Quitamos el "Get" antes de "$get"
                        modifyQueryUsing: fn (Builder $query, $get) => 
                            $query->where('prueba_id', $get('prueba_id'))
                    )
                    ->required()
                    ->preload(),

                Select::make('aplicativo_id')
                    ->label('Aplicativo evaluado')
                    ->relationship('aplicativo', 'nombre')
                    ->required()
                    ->native(false),

                DateTimePicker::make('fecha_sesion')
                    ->label('Fecha y Hora')
                    ->default(now())
                    ->required(),

                TextInput::make('moderador')
                    ->label('Moderador')
                    ->default(auth()->user()->name)
                    ->readOnly(),
            ]);
    }
}