<?php

namespace App\Filament\Resources\Hallazgos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HallazgosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prueba_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('severidad_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('prioridad_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estado_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('frecuencia')
                    ->searchable(),
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
