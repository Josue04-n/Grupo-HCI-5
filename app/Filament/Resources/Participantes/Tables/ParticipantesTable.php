<?php

namespace App\Filament\Resources\Participantes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParticipantesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // CAMBIO AQUÍ: Usamos la relación 'prueba' para mostrar el 'nombre'
                TextColumn::make('prueba.nombre')
                    ->label('Plan de Prueba')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('codigo')
                    ->label('ID Participante')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('perfil')
                    ->label('Perfil de Usuario')
                    ->searchable(),

                TextColumn::make('experiencia')
                    ->label('Nivel de Experiencia')
                    ->searchable(),

                TextColumn::make('edad')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //

            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([ // Corregido: bulkActions suele envolver a BulkActionGroup
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}