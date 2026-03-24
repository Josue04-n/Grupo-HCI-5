<?php

namespace App\Filament\Resources\Sesions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SesionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prueba_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('participante_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tarea_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('aplicativo_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fecha_sesion')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('moderador')
                    ->searchable(),
                TextColumn::make('created_at')
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
