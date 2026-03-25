<?php

namespace App\Filament\Resources\CatAplicativos\Pages;

use App\Filament\Resources\CatAplicativos\CatAplicativoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatAplicativos extends ListRecords
{
    protected static string $resource = CatAplicativoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
