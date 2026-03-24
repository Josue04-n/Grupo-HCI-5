<?php

namespace App\Filament\Resources\Observacions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ObservacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sesion_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('severidad_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('exito')
                    ->badge(),
                TextColumn::make('eficacia')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('eficiencia')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('satisfaccion')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tiempo_seg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('errores')
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
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
