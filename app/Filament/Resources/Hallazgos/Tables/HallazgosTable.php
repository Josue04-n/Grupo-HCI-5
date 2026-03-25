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
                // 1. Mostramos el nombre de la prueba (JEP / Maquita)
                TextColumn::make('prueba.nombre')
                    ->label('Plan de Prueba')
                    ->sortable()
                    ->searchable(),

                // 2. Severidad con colores (Rojo para Alta, etc.)
                TextColumn::make('severidad.nombre')
                    ->label('Severidad')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Baja' => 'gray',
                        'Media' => 'warning',
                        'Alta' => 'danger',
                        'Crítica' => 'danger',
                        default => 'primary',
                    })
                    ->sortable(),

                // 3. Prioridad
                TextColumn::make('prioridad.nombre')
                    ->label('Prioridad')
                    ->badge()
                    ->sortable(),

                // 4. Estado (Identificado, Solucionado...)
                TextColumn::make('estado.nombre')
                    ->label('Estado')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('frecuencia')
                    ->label('Frecuencia')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([ // Corregido para evitar errores en versiones estables
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}