<?php

namespace App\Filament\Resources\CatEstadoPruebas\Pages;

use App\Filament\Resources\CatEstadoPruebas\CatEstadoPruebaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatEstadoPruebas extends ListRecords
{
    protected static string $resource = CatEstadoPruebaResource::class;
    protected static ?string $breadcrumb = 'Lista';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Estado de Prueba')
                ->icon('heroicon-o-plus'),
        ];
    }
}
