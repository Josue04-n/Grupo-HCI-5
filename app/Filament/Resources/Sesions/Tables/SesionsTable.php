<?php

namespace App\Filament\Resources\Sesions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Builder; 

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
                SelectFilter::make('participante_codigo')
                    ->label('Filtrar por Participante')
                    ->options(fn () => \App\Models\Participante::select('codigo')->distinct()->pluck('codigo', 'codigo')->toArray())
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('participante', function ($q) use ($data) {
                                $q->where('codigo', $data['value']);
                            });
                        }
                    }),

                SelectFilter::make('tarea_codigo')
                    ->label('Filtrar por Tarea')
                    ->options(fn () => \App\Models\Tarea::select('codigo')->distinct()->pluck('codigo', 'codigo')->toArray())
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('tarea', function ($q) use ($data) {
                                $q->where('codigo', $data['value']);
                            });
                        }
                    }),
                
                SelectFilter::make('aplicativo_id')
                    ->label('Filtrar por Aplicativo')
                    ->relationship('aplicativo', 'nombre')
                    ->preload(),
            ])
            ->actions([
                EditAction::make()
                    ->label('Edición'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}