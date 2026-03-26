<?php

namespace App\Filament\Resources\CatSeveridads\Pages;

use App\Filament\Resources\CatSeveridads\CatSeveridadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatSeveridads extends ListRecords
{
    protected static string $resource = CatSeveridadResource::class;
    protected static ?string $breadcrumb = 'Lista';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Severidad')
                ->icon('heroicon-o-plus'),

        ];
    }
}
