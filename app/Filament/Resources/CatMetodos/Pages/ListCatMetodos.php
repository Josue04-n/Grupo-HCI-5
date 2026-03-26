<?php

namespace App\Filament\Resources\CatMetodos\Pages;

use App\Filament\Resources\CatMetodos\CatMetodoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatMetodos extends ListRecords
{
    protected static string $resource = CatMetodoResource::class;
    protected static ?string $breadcrumb = 'Lista';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Método de Evaluación')
                ->icon('heroicon-o-plus'),
        ];
    }
}
