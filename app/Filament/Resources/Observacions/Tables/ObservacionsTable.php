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
                // 1. SESIÓN: Mostramos Participante y Tarea a través de la relación
                TextColumn::make('sesion.participante.codigo')
                    ->label('Sujeto')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('sesion.tarea.codigo')
                    ->label('Tarea')
                    ->sortable(),

                TextColumn::make('sesion.aplicativo.nombre')
                    ->label('App')
                    ->sortable(),

                // 2. SEVERIDAD: Nombre en lugar de ID
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

                // 3. MÉTRICAS
                TextColumn::make('exito')
                    ->label('Resultado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Sí, sin ayuda' => 'success',
                        'No completó' => 'danger',
                        default => 'warning',
                    }),

                TextColumn::make('tiempo_seg')
                    ->label('Tiempo (s)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('errores')
                    ->label('Errores')
                    ->numeric()
                    ->sortable()
                    ->color('danger'),

                TextColumn::make('satisfaccion')
                    ->label('Satisfacción')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([ // Corregido a bulkActions para evitar errores
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}