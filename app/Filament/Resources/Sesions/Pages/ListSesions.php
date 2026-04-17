<?php

namespace App\Filament\Resources\Sesions\Pages;

use App\Filament\Resources\Sesions\SesionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSesions extends ListRecords
{
    protected static string $resource = SesionResource::class;
    protected static ?string $breadcrumb = 'Lista';


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nueva Sesión')
                ->icon('heroicon-o-plus'),
        ];
    }
}
