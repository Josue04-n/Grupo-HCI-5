<?php

namespace App\Filament\Resources\PruebaUsabilidads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\CatMetodo;
use App\Models\CatEstadoPrueba;
use App\Models\CatAplicativo;
use App\Models\CatPrioridad;
use App\Models\CatSeveridad;

class PruebaUsabilidadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable(),
                TextColumn::make('metodo.nombre')
                    ->label('Método')
                    ->sortable(),
                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                    'Planificada' => 'info',
                    'En curso' => 'warning',
                    'Completada' => 'success',
                    'Cancelada' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('nombre')
                    ->searchable(),
                TextColumn::make('producto')
                    ->searchable(),
                TextColumn::make('modulo')
                    ->searchable(),
                TextColumn::make('fecha')
                    ->date()
                    ->sortable(),
                TextColumn::make('lugar')
                    ->searchable(),
                TextColumn::make('duracion')
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
