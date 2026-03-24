<?php

namespace App\Filament\Resources\Sesions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SesionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prueba.nombre')
                    ->label('Plan de Prueba')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('participante.codigo')
                    ->label('Participante')
                    ->badge()
                    ->color('info'),

                TextColumn::make('tarea.codigo')
                    ->label('Tarea')
                    ->badge(),

                TextColumn::make('aplicativo.nombre')
                    ->label('Aplicativo')
                    ->color('success'),

                TextColumn::make('fecha_sesion')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('moderador')
                    ->label('Moderador'),
            ]);
    }
}