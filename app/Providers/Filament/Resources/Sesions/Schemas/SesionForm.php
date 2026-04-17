<?php

namespace App\Filament\Resources\Sesions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SesionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Selección de la Prueba
                Select::make('prueba_id')
                    ->label('Plan de Prueba')
                    ->relationship('prueba', 'nombre')
                    ->required()
                    ->live() 
                    ->preload(),

                // 2. Selección del Participante (Filtrado corregido)
                Select::make('participante_id')
                    ->label('Participante')
                    ->relationship(
                        name: 'participante', 
                        titleAttribute: 'codigo',
                        modifyQueryUsing: fn (Builder $query, $get) => 
                            $query->where('prueba_id', $get('prueba_id'))
                    )
                    ->required()
                    ->searchable()
                    ->preload(),

                // 3. Selección de la Tarea (Filtrado corregido)
                Select::make('tarea_id')
                    ->label('Tarea a evaluar')
                    ->relationship(
                        name: 'tarea', 
                        titleAttribute: 'codigo',
                        modifyQueryUsing: fn (Builder $query, $get) => 
                            $query->where('prueba_id', $get('prueba_id'))
                    )
                    ->required()
                    ->preload(),

                // 4. Selección del Aplicativo
                Select::make('aplicativo_id')
                    ->label('Aplicativo evaluado')
                    ->relationship('aplicativo', 'nombre')
                    ->required()
                    ->native(false),

                // 5. Datos de control
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