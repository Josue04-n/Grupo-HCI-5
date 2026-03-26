<?php

namespace App\Filament\Resources\CatAplicativos\Pages;

use App\Filament\Resources\CatAplicativos\CatAplicativoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatAplicativos extends ListRecords
{
    protected static string $resource = CatAplicativoResource::class;
    protected static ?string $breadcrumb = 'Lista';


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Aplicativo')
                ->icon('heroicon-o-plus'),
        ];
    }
}
