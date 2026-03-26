<?php

namespace App\Filament\Resources\CatEstadoHallazgos\Pages;

use App\Filament\Resources\CatEstadoHallazgos\CatEstadoHallazgoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatEstadoHallazgos extends ListRecords
{
    protected static string $resource = CatEstadoHallazgoResource::class;
    protected static ?string $breadcrumb = 'Lista';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Estado de Hallazgo')
                ->icon('heroicon-o-plus'),
        ];
    }
}
