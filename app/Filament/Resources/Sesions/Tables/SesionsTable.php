<?php

namespace App\Filament\Resources\Sesions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter; // Importamos el componente de filtros
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

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
                    ->color('info')
                    ->sortable(),

                TextColumn::make('tarea.codigo')
                    ->label('Tarea')
                    ->badge()
                    ->sortable(),

                TextColumn::make('aplicativo.nombre')
                    ->label('Aplicativo')
                    ->color('success')
                    ->sortable(),

                TextColumn::make('fecha_sesion')
                    ->label('Fecha')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('moderador')
                    ->label('Moderador')
                    ->searchable(),
            ])
            ->filters([
                // Filtro por Participante (Lista única de la tabla Participantes)
                SelectFilter::make('participante_id')
                    ->label('Filtrar por Participante')
                    // Usamos options() para asegurar que solo salgan una vez
                    ->options(fn () => \App\Models\Participante::pluck('codigo', 'id')->toArray())
                    ->searchable()
                    ->preload(),

                // Filtro por Tarea (Lista única de la tabla Tareas)
                SelectFilter::make('tarea_id')
                    ->label('Filtrar por Tarea')
                    ->options(fn () => \App\Models\Tarea::pluck('codigo', 'id')->toArray())
                    ->searchable()
                    ->preload(),
                
                // Filtro por Aplicativo
                SelectFilter::make('aplicativo_id')
                    ->label('Filtrar por Aplicativo')
                    ->options(fn () => \App\Models\CatAplicativo::pluck('nombre', 'id')->toArray())
                    ->preload(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}