<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\PruebaUsabilidad;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('prueba_id')
                    ->label('Filtrar por Proyecto / Prueba')
                    ->options(PruebaUsabilidad::pluck('nombre', 'id'))
                    ->searchable()
                    ->preload()
                    ->live(), // Recarga los widgets automáticamente
            ])
            ->columns(3);
    }
}
